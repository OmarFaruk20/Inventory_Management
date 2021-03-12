<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnIndexing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('return_parent_id');
        });

        Schema::table('account_transactions', function (Blueprint $table) {
            $table->index('account_id');
            $table->index('transaction_id');
            $table->index('transaction_payment_id');
            $table->index('transfer_transaction_id');
            $table->index('created_by');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index('table_id');
            $table->index('waiter_id');
            $table->index('location_id');
        });

        Schema::table('variations', function (Blueprint $table) {
            $table->index('variation_value_id');
        });

        Schema::table('cash_register_transactions', function (Blueprint $table) {
            $table->index('transaction_id');
        });

        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->index('sub_unit_id');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->index('base_unit_id');
        });

        Schema::table('discounts', function (Blueprint $table) {
            $table->index('business_id');
            $table->index('brand_id');
            $table->index('category_id');
            $table->index('location_id');
            $table->index('priority');
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
