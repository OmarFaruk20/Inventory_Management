<?php

namespace App\Utils;

use App\Business;
use App\Variation;
use App\VariationLocationDetails;
use App\Product;
use App\VariationTemplate;
use App\VariationValueTemplate;

use DB;
use Illuminate\Database\QueryException;

class InstallUtil extends Util
{
    /**
     * Remove all products from stock adjustment and add the corresponding in
     * quantity available.
     * USED ONLY TO UPDATE FROM VERSION 1.1 to 1.2
     *
     * DEPRECIATED AFTER 1.2
     *
     * @return int
     */
    public function resetStockAdjustmentForAllBusiness()
    {
        try {
            DB::beginTransaction();

            //Get all business
            $businesses = Business::all();

            foreach ($businesses as $business) {
                $stock_adjustments = DB::table('stock_adjustments')
                                        ->where('business_id', $business->id)
                                        ->get();

                if (!empty($stock_adjustments)) {
                    foreach ($stock_adjustments as $sa) {
                        $sa_lines = DB::table('stock_adjustment_lines')
                                        ->where('stock_adjustment_id', $sa->id)
                                        ->get();

                        if (!empty($sa_lines) && is_array($sa_lines)) {
                            foreach ($sa_lines as $line) {
                                $variation = Variation::where('id', $line->variation_id)
                                                ->where('product_id', $line->product_id)
                                                ->first();

                                if (!empty($variation)) {
                                    $variation_location_d = VariationLocationDetails
                                        ::where('variation_id', $variation->id)
                                        ->where('product_id', $line->product_id)
                                        ->where('product_variation_id', $variation->product_variation_id)
                                        ->where('location_id', $sa->location_id)
                                        ->increment('qty_available', $line->quantity);
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
        } catch (QueryException $e) {
            abort(404);
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }

    /**
     * Get system information as per the key passed.
     *
     * @param string $key
     * @return mixed
     */
    public function getSystemInfo($key)
    {
        $system = DB::table('system')->where('key', $key)->first();

        if (!empty($system)) {
            return $system->value;
        } else {
            return null;
        }
    }

    /**
     * Set system information as per the key value passed
     *
     * @param string $key
     * @param string $value
     *
     * @return mixed
     */
    public function setSystemInfo($key, $value)
    {
        DB::table('system')->where('key', $key)->update(['value' => $value]);
    }

    /**
     * Runs only if updated from v 1.3 to v2.0
     *
     * @param float $db_version
     * @param float $app_version
     *
     * @return boolean
     */
    public function updateFrom13To20($db_version, $app_version)
    {
        if ($db_version == 1.3 && $app_version == 2.0) {
            //Fix for purchase_lines table, copy data from  purchase_price to pp_without_discount
            DB::update('UPDATE `purchase_lines` set pp_without_discount=purchase_price');
        }

        return true;
    }

    /**
     * This function checks for product variations, maps if existing in
     * template or else create a new variation template
     *
     * @return void
     */
    public function createExistingProductsVariationsToTemplate()
    {
        try {
            DB::beginTransaction();

            //Get all the variable products
            $variable_products = Product::where('type', 'variable')
                                    ->with('product_variations', 'product_variations.variations')
                                    ->get();

            //Check if variation template exists; If not create new
            foreach ($variable_products as $product) {
                foreach ($product->product_variations as $product_variation) {
                    //Update Product variations
                    $variation_template = VariationTemplate::where('business_id', $product->business_id)
                                    ->whereRaw('LOWER(name) = "' . strtolower($product_variation->name) . '"')
                                    ->with(['values'])
                                    ->first();

                    if (empty($variation_template)) {
                        $variation_template = VariationTemplate::create([
                            'business_id' => $product->business_id,
                            'name' => $product_variation->name
                        ]);
                    }
                    $product_variation->variation_template_id = $variation_template->id;
                    $product_variation->save();

                    //Update variations
                    foreach ($product_variation->variations as $variation) {
                        //Search variation value;If not found create new
                        $variation_value = $variation_template->values->filter(function ($item) use ($variation) {
                            return strtolower($variation->name) == strtolower($item->name);
                        })->first();

                        if (empty($variation_value)) {
                            $variation_value = VariationValueTemplate::create([
                                'name' => $variation->name,
                                'variation_template_id' => $variation_template->id
                            ]);
                        }
                        $variation->variation_value_id = $variation_value->id;
                        $variation->save();
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
