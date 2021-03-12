<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupSubTaxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_sub_taxes', function (Blueprint $table) {
            $table->integer('group_tax_id')->unsigned();
            $table->foreign('group_tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
            $table->integer('tax_id')->unsigned();
            $table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
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
