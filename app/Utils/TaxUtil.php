<?php

namespace App\Utils;

use App\TaxRate;
use App\GroupSubTax;

class TaxUtil extends Util
{

    /**
     * Updates tax amount of a tax group
     *
     * @param int $group_tax_id
     *
     * @return void
     */
    public function updateGroupTaxAmount($group_tax_id)
    {
        $amount = 0;
        $tax_rate = TaxRate::where('id', $group_tax_id)->with(['sub_taxes'])->first();
        foreach ($tax_rate->sub_taxes as $sub_tax) {
            $amount += $sub_tax->amount;
        }
        $tax_rate->amount = $amount;
        $tax_rate->save();
    }
}
