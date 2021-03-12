<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexingTransactionSellLinesPurchaseLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_sell_lines_purchase_lines', function (Blueprint $table) {
            $table->index('sell_line_id', 'sell_line_id');
            $table->index('stock_adjustment_line_id', 'stock_adjustment_line_id');
            $table->index('purchase_line_id', 'purchase_line_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
