<?php

namespace App\Http\Controllers;

use App\Business;

use App\BusinessLocation;
use App\Product;
use App\Transaction;
use App\Utils\ProductUtil;
use App\Variation;

use DB;

use Excel;
use Illuminate\Http\Request;

class ImportOpeningStockController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $productUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil)
    {
        $this->productUtil = $productUtil;
    }

    /**
     * Display import product screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('product.opening_stock')) {
            abort(403, 'Unauthorized action.');
        }

        $zip_loaded = extension_loaded('zip') ? true : false;

        $date_formats = Business::date_formats();
        $date_format = session('business.date_format');
        $date_format = isset($date_formats[$date_format]) ? $date_formats[$date_format] : $date_format;

        //Check if zip extension it loaded or not.
        if ($zip_loaded === false) {
            $notification = ['success' => 0,
                            'msg' => 'Please install/enable PHP Zip archive for import'
                        ];

            return view('import_opening_stock.index')
                ->with(compact('notification', 'date_format'));
        } else {
            return view('import_opening_stock.index')
                ->with(compact('date_format'));
        }
    }

    /**
     * Imports the uploaded file to database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('product.opening_stock')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            //Set maximum php execution time
            ini_set('max_execution_time', 0);

            if ($request->hasFile('products_csv')) {
                $file = $request->file('products_csv');
                $imported_data = Excel::load($file->getRealPath())
                                ->noHeading()
                                ->skipRows(1)
                                ->get()
                                ->toArray();
                $business_id = $request->session()->get('user.business_id');
                $user_id = $request->session()->get('user.id');

                $formated_data = [];

                $is_valid = true;
                $error_msg = '';
                
                DB::beginTransaction();
                foreach ($imported_data as $key => $value) {
                    $row_no = $key + 1;

                    //Check for product SKU, get product id, variation id.
                    if (!empty($value[0])) {
                        $product_info = Variation::where('sub_sku', $value[0])
                                ->join('products AS P', 'variations.product_id', '=', 'P.id')
                                ->leftjoin('tax_rates AS TR', 'P.tax', 'TR.id')
                                ->where('P.business_id', $business_id)
                                ->select(['P.id', 'variations.id as variation_id',
                                    'P.enable_stock', 'TR.amount as tax_percent',
                                    'TR.id as tax_id'])
                                ->first();
                        if (empty($product_info)) {
                            $is_valid =  false;
                            $error_msg = "Invalid PRODUCT SKU in row no. $row_no";
                            break;
                        } elseif ($product_info->enable_stock == 0) {
                            $is_valid =  false;
                            $error_msg = "Manage Stock not enabled for PRODUCT SKU in row no. $row_no";
                            break;
                        }
                    } else {
                        $is_valid =  false;
                        $error_msg = "PRODUCT SKU is required in row no. $row_no";
                        break;
                    }

                    //Get location details.
                    if (!empty(trim($value[1]))) {
                        $location_name = trim($value[1]);
                        $location = BusinessLocation::where('name', $location_name)
                                            ->where('business_id', $business_id)
                                            ->first();
                        if (empty($location)) {
                            $is_valid = false;
                            $error_msg = "No location with name '$location_name' found in row no. $row_no";
                            break;
                        }
                    } else {
                        $location = BusinessLocation::where('business_id', $business_id)->first();
                    }

                    $opening_stock = ['quantity' => trim($value[2]),
                                        'location_id' => $location->id,
                                        'lot_number' => trim($value[4]),
                                    ];
                    if (!empty(trim($value[5]))) {
                        $opening_stock['exp_date'] = $this->productUtil->uf_date($value[5]);
                    }

                    if (!empty(trim($value[3]))) {
                        $unit_cost_before_tax = trim($value[3]);
                    } else {
                        $is_valid = false;
                        $error_msg = "Invalid UNIT COST in row no. $row_no";
                        break;
                    }

                    if (!is_numeric(trim($value[2]))) {
                        $is_valid = false;
                        $error_msg = "Invalid quantity $value[2] in row no. $row_no";
                        break;
                    }

                    //Check for tra, location_id, opening_stock_product_id, type=opening stock.
                    $os_transaction = Transaction::where('business_id', $business_id)
                            ->where('location_id', $location->id)
                            ->where('type', 'opening_stock')
                            ->where('opening_stock_product_id', $product_info->id)
                            ->first();

                    $this->addOpeningStock($opening_stock, $product_info, $business_id, $unit_cost_before_tax, $os_transaction);

                    // //If exist add to it.
                    // if(!empty($os_transaction)){
                    //  //If not create new
                        
                    // } else {
                    //  //If not create new
                    //  $this->addOpeningStock($opening_stock, $product_info, $business_id, $unit_cost_before_tax);
                    // }
                }
            }

            if (!$is_valid) {
                throw new \Exception($error_msg);
            }

            $output = ['success' => 1,
                            'msg' => __('product.file_imported_successfully')
                        ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage()
                        ];
            return redirect('import-opening-stock')->with('notification', $output);
        }

        return redirect('import-opening-stock')->with('status', $output);
    }

    /**
     * Adds opening stock of a single product
     *
     * @param array $opening_stock
     * @param obj $product
     * @param int $business_id
     * @return void
     */
    private function addOpeningStock($opening_stock, $product, $business_id, $unit_cost_before_tax, $transaction = null)
    {
        $user_id = request()->session()->get('user.id');

        $transaction_date = request()->session()->get("financial_year.start");
        $transaction_date = \Carbon::createFromFormat('Y-m-d', $transaction_date)->toDateTimeString();

        //Get product tax
        $tax_percent = !empty($product->tax_percent) ? $product->tax_percent : 0;
        $tax_id = !empty($product->tax_id) ? $product->tax_id : null;

        $item_tax = $this->productUtil->calc_percentage($unit_cost_before_tax, $tax_percent);

        //total before transaction tax
        $total_before_trans_tax = $opening_stock['quantity'] * ($unit_cost_before_tax + $item_tax);

        //Add opening stock transaction
        if (empty($transaction)) {
            $transaction = new Transaction();
            $transaction->type = 'opening_stock';
            $transaction->opening_stock_product_id = $product->id;
            $transaction->business_id = $business_id;
            $transaction->transaction_date = $transaction_date;
            $transaction->location_id = $opening_stock['location_id'];
            $transaction->payment_status = 'paid';
            $transaction->created_by = $user_id;
            $transaction->total_before_tax = 0;
            $transaction->final_total = 0;
        }
        $transaction->total_before_tax += $total_before_trans_tax;
        $transaction->final_total += $total_before_trans_tax;
        $transaction->save();

        //Create purchase line
        $transaction->purchase_lines()->create([
                        'product_id' => $product->id,
                        'variation_id' => $product->variation_id,
                        'quantity' => $opening_stock['quantity'],
                        'pp_without_discount' => $unit_cost_before_tax,
                        'item_tax' => $item_tax,
                        'tax_id' => $tax_id,
                        'pp_without_discount' => $unit_cost_before_tax,
                        'purchase_price' => $unit_cost_before_tax,
                        'purchase_price_inc_tax' => $unit_cost_before_tax + $item_tax,
                        'exp_date' => !empty($opening_stock['exp_date']) ? $opening_stock['exp_date'] : null,
                        'lot_number' => !empty($opening_stock['lot_number']) ? $opening_stock['lot_number'] : null,
                    ]);
        //Update variation location details
        $this->productUtil->updateProductQuantity($opening_stock['location_id'], $product->id, $product->variation_id, $opening_stock['quantity']);
    }
}
