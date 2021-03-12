<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecurringInvoiceFieldsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(0)->after('created_by');
            $table->float('recur_interval', 8, 2)->nullable()->after('is_recurring');
            $table->enum('recur_interval_type', ['days', 'months', 'years'])->nullable()->after('recur_interval');
            $table->integer('recur_repetitions')->nullable()->after('recur_interval_type');
            $table->dateTime('recur_stopped_on')->nullable()->after('recur_repetitions');
            $table->integer('recur_parent_id')->nullable()->after('recur_stopped_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
