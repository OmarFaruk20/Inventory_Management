<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifiersRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_product_modifier_sets', function (Blueprint $table) {
            $table->integer('modifier_set_id')->unsigned();
            $table->foreign('modifier_set_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->comment("Table use to store the modifier sets applicable for a product");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('res_product_modifier_sets');
        Schema::dropIfExists('res_product_modifier_sets');
    }
}
