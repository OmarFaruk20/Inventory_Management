<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestaurantFieldsInTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('res_table_id')->unsigned()->nullable()->after('location_id')->comment('fields to restaurant module');
            $table->integer('res_waiter_id')->unsigned()->nullable()->after('res_table_id')->comment('fields to restaurant module');
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
