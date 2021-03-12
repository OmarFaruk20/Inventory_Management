<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubUnitIdToPurchaseLinesAndSellLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->integer('sub_unit_id')->nullable()->after('lot_number');
        });

        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            $table->integer('sub_unit_id')->nullable()->after('parent_sell_line_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
