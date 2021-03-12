<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTransactionPaymentsTableForContactPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE transaction_payments MODIFY COLUMN transaction_id INT(11) UNSIGNED DEFAULT NULL");

        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('payment_for')->after('created_by')->nullable();
            $table->integer('parent_id')->after('payment_for')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            //
        });
    }
}
