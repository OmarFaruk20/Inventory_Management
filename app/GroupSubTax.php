<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupSubTax extends Model
{
    public function tax_rate()
    {
        return $this->belongsTo(\App\TaxRate::class, 'group_tax_id');
    }
}
