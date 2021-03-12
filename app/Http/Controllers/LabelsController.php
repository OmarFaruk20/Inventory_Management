<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Barcode;

use App\Utils\TransactionUtil;
use App\Utils\ProductUtil;

class LabelsController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $transactionUtil;
    protected $productUtil;

    /**
     * Constructor
     *
     * @param TransactionUtil $TransactionUtil
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
    }

    /**
     * Display labels
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $purchase_id = $request->get('purchase_id', false);
        $product_id = $request->get('product_id', false);

        //Get products for the business
        $products = [];
        if ($purchase_id) {
            $products = $this->transactionUtil->getPurchaseProducts($business_id, $purchase_id);
        } elseif ($product_id) {
            $products = $this->productUtil->getDetailsFromProduct($business_id, $product_id);
        }

        $barcode_settings = Barcode::where('business_id', $business_id)
                                ->orWhereNull('business_id')
                                ->pluck('name', 'id');

        return view('labels.show')
            ->with(compact('products', 'barcode_settings'));
    }

    /**
     * Returns the html for product row
     *
     * @return \Illuminate\Http\Response
     */
    public function addProductRow(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $business_id = $request->session()->get('user.business_id');
            
            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($business_id, $product_id, $variation_id);
                
                return view('labels.partials.show_table_rows')
                        ->with(compact('products', 'index'));
            }
        }
    }

    /**
     * Returns the html for labels preview
     *
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        if ($request->ajax()) {
            try {
                $products = $request->get('products');
                $print = $request->get('print');
                $barcode_setting = $request->get('barcode_setting');
                $business_id = $request->session()->get('user.business_id');

                $barcode_details = Barcode::find($barcode_setting);
                //print_r($barcode_details);exit;
                $business_name = $request->session()->get('business.name');

                $product_details = [];
                $total_qty = 0;
                foreach ($products as $value) {
                    $details = $this->productUtil->getDetailsFromVariation($value['variation_id'], $business_id, null, false);
                    $product_details[] = ['details' => $details, 'qty' => $value['quantity']];
                    $total_qty += $value['quantity'];
                }

                $page_height = null;
                if ($barcode_details->is_continuous) {
                    $rows = ceil($total_qty/$barcode_details->stickers_in_one_row) + 0.4;
                    $barcode_details->paper_height = $barcode_details->top_margin + ($rows*$barcode_details->height) + ($rows*$barcode_details->row_distance);
                }

                $html = view('labels.partials.preview')
                    ->with(compact('print', 'product_details', 'business_name', 'barcode_details', 'page_height'))->render();

                $output = ['html' => $html,
                                'success' => true,
                                'msg' => ''
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['html' => '',
                        'success' => false,
                        'msg' =>  __('lang_v1.barcode_label_error')
                    ];
            }

            return $output;
        }
    }
}
