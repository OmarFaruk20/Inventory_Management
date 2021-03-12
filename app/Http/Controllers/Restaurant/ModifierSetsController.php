<?php

namespace App\Http\Controllers\Restaurant;

use App\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

use App\Utils\ProductUtil;

class ModifierSetsController extends Controller
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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $modifer_set = Product::where('business_id', $business_id)
                            ->where('type', 'modifier')
                            ->with(['variations', 'modifier_products']);

            return \Datatables::of($modifer_set)
                ->addColumn(
                    'action',
                    '
                    @can("product.update")
                        <button type="button" data-href="{{action(\'Restaurant\ModifierSetsController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_modifier_button" data-container=".modifier_modal"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                        <button type="button" data-href="{{action(\'Restaurant\ProductModifierSetController@edit\', [$id])}}" class="btn btn-xs btn-info edit_modifier_button" data-container=".modifier_modal"><i class="fa fa-cubes"></i> @lang("restaurant.manage_products")</button>
                    &nbsp;
                    @endcan

                    @can("product.delete")
                        <button data-href="{{action(\'Restaurant\ModifierSetsController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_modifier_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan
                    '
                )
                ->editColumn('modifier_products', function ($row) {
                    $products = [];
                    foreach ($row->modifier_products as $product) {
                        $products[] = $product->name;
                    }
                    return implode(',  ', $products);
                })
                ->editColumn('variations', function ($row) {
                    $modifiers = [];
                    foreach ($row->variations as $modifier) {
                        $modifiers[] = $modifier->name;
                    }
                    return implode(', ', $modifiers);
                })
                ->removeColumn('id')
                ->escapeColumns(['action'])
                ->make(true);
        }

        return view('restaurant.modifier_sets.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if (!auth()->user()->can('product.create')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('restaurant.modifier_sets.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            if (!auth()->user()->can('product.create')) {
                abort(403, 'Unauthorized action.');
            }

            $input = $request->all();
            $business_id = $request->session()->get('user.business_id');
            $user_id = $request->session()->get('user.id');

            $modifer_set_data = [
                'name' => $input['name'],
                'type' => 'modifier',
                'sku' => ' ',
                'tax_type' => 'inclusive',
                'alert_quantity' => 0,
                'business_id' => $business_id,
                'created_by' => $user_id
            ];

            DB::beginTransaction();
            $modifer_set = Product::create($modifer_set_data);

            $sku = $this->productUtil->generateProductSku($modifer_set->id);
            $modifer_set->sku = $sku;
            $modifer_set->save();

            $modifers = [];
            foreach ($input['modifier_name'] as $key => $value) {
                $modifers[] = [
                    'value' => $value,
                    'default_purchase_price' => $input['modifier_price'][$key],
                    'dpp_inc_tax' => $input['modifier_price'][$key],
                    'profit_percent' => 0,
                    'default_sell_price' => $input['modifier_price'][$key],
                    'sell_price_inc_tax' => $input['modifier_price'][$key],
                ];
            }

            $modifiers_data = [];
            $modifiers_data[] = [
                'name' => 'DUMMY',
                'variations' => $modifers
            ];
            $this->productUtil->createVariableProductVariations($modifer_set->id, $modifiers_data);

            DB::commit();

            $output = ['success' => 1, 'msg' => __("lang_v1.added_success")];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0, 'msg' => __("messages.something_went_wrong")];
        }

        return $output;
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('restaurant.modifier_sets.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id, Request $request)
    {
        if (!auth()->user()->can('product.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');

            $modifer_set = Product::where('business_id', $business_id)
                            ->where('id', $id)
                            ->with(['variations'])
                            ->first();

            return view('restaurant.modifier_sets.edit')
                ->with(compact('modifer_set'));
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0, 'msg' => __("messages.something_went_wrong")];
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        if (!auth()->user()->can('product.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $input = $request->all();
            $business_id = $request->session()->get('user.business_id');
            $user_id = $request->session()->get('user.id');

            $modifer_set = Product::where('business_id', $business_id)
                    ->where('id', $id)
                    ->where('type', 'modifier')
                    ->first();
            $modifer_set->update(['name' => $input['name']]);

            //Get the dummy product variation
            $product_variation = $modifer_set->product_variations()->first();

            $modifiers_data[$product_variation->id]['name'] = $product_variation->name;

            $variations_edit = [];
            $variations = [];

            //Set existing variations
            if (!empty($input['modifier_name_edit'])) {
                $modifier_name_edit = $input['modifier_name_edit'];
                $modifier_price_edit = $input['modifier_price_edit'];

                foreach ($modifier_name_edit as $key => $name) {
                    if (isset($modifier_price_edit[$key])) {
                        $variations_edit[$key]['value'] = $name;
                        $variations_edit[$key]['default_purchase_price'] = $modifier_price_edit[$key];
                        $variations_edit[$key]['dpp_inc_tax'] = $modifier_price_edit[$key];
                        $variations_edit[$key]['default_sell_price'] = $modifier_price_edit[$key];
                        $variations_edit[$key]['sell_price_inc_tax'] = $modifier_price_edit[$key];
                        $variations_edit[$key]['profit_percent'] = 0;
                    }
                }
            }
            //Set new variations
            if (!empty($input['modifier_name'])) {
                foreach ($input['modifier_name'] as $key => $value) {
                    $variations[] = [
                        'value' => $value,
                        'default_purchase_price' => $input['modifier_price'][$key],
                        'dpp_inc_tax' => $input['modifier_price'][$key],
                        'profit_percent' => 0,
                        'default_sell_price' => $input['modifier_price'][$key],
                        'sell_price_inc_tax' => $input['modifier_price'][$key],
                    ];
                }
            }

            //Update variations
            $modifiers_data[$product_variation->id]['variations_edit'] = $variations_edit;
            $modifiers_data[$product_variation->id]['variations'] = $variations;
            $this->productUtil->updateVariableProductVariations($modifer_set->id, $modifiers_data);

            DB::commit();

            $output = ['success' => 1, 'msg' => __("lang_v1.updated_success")];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0, 'msg' => __("messages.something_went_wrong")];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if (!auth()->user()->can('product.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $business_id = $request->session()->get('user.business_id');

            Product::where('business_id', $business_id)
                ->where('type', 'modifier')
                ->where('id', $id)
                ->delete();

            DB::commit();

            $output = ['success' => 1, 'msg' => __("lang_v1.deleted_success")];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0, 'msg' => __("messages.something_went_wrong")];
        }

        return $output;
    }
}
