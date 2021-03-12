<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\TransactionSellLine;

class AddUnitPriceBeforeDiscountColumnToTransactionSellLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            $table->decimal('unit_price_before_discount', 20, 2)->after('quantity')->default(0);
        });

        //Set all unit_price_before_discount value same as unit_price value
        $sell_lines = TransactionSellLine::get();
        foreach ($sell_lines as $sell_line) {
            $sell_line->unit_price_before_discount = $sell_line->unit_price;
            $sell_line->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            //
        });
    }
}
