<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class StockAdjustmentMoveToTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `transactions` CHANGE `type` `type` ENUM('purchase','sell','expense','stock_adjustment') DEFAULT NULL");

        DB::statement("SET FOREIGN_KEY_CHECKS = 0");

        DB::statement("DROP TABLE IF EXISTS stock_adjustment_lines");

        Schema::create('stock_adjustment_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('variation_id')->unsigned();
            $table->foreign('variation_id')->references('id')->on('variations')
            ->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 20, 2)->comment("Last purchase unit price")->nullable();
            $table->timestamps();

            //Indexing
            $table->index('transaction_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('adjustment_type', ['normal', 'abnormal'])->nullable()->after('payment_status');
            $table->decimal('total_amount_recovered', 20, 2)->comment("Used for stock adjustment.")->nullable()->after('exchange_rate');
        });

        //Create & Rename stock_adjustment table.
        DB::statement("CREATE TABLE IF NOT EXISTS `stock_adjustments` (`id` int(11) DEFAULT NULL) ");
        Schema::rename('stock_adjustments', 'stock_adjustments_temp');

        DB::statement("SET FOREIGN_KEY_CHECKS = 1");
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
