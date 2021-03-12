<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->boolean('purchase_in_diff_currency')->default(0)->after('enable_tooltip')->comment("Allow purchase to be in different currency then the business currency");

            $table->integer('purchase_currency_id')->unsigned()->nullable()->references('id')->on('currencies')->after('purchase_in_diff_currency');

            $table->decimal('p_exchange_rate', 5, 3)->default(1)->after('purchase_currency_id')->comment("1 Purchase currency = ? Base Currency");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business', function (Blueprint $table) {
            //
        });
    }
}
