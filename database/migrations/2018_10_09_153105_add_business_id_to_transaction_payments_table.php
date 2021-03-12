<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\TransactionPayment;

class AddBusinessIdToTransactionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('business_id')->after('transaction_id')->nullable();
        });

        $transaction_payments = TransactionPayment::with(['created_user'])->get();
        foreach ($transaction_payments as $transaction_payment) {
            $transaction_payment->business_id = optional($transaction_payment->created_user)->business_id;
            $transaction_payment->save();
        }
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
