<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('header_text')->nullable();
            $table->string('invoice_no_prefix')->nullable();
            $table->string('invoice_heading')->nullable();
            $table->string('sub_total_label')->nullable();
            $table->string('discount_label')->nullable();
            $table->string('tax_label')->nullable();
            $table->string('total_label')->nullable();
            $table->string('logo')->nullable();

            $table->boolean('show_logo')->default(0);
            $table->boolean('show_business_name')->default(0);
            $table->boolean('show_location_name')->default(1);
            $table->boolean('show_landmark')->default(1);
            $table->boolean('show_city')->default(1);
            $table->boolean('show_state')->default(1);
            $table->boolean('show_zip_code')->default(1);
            $table->boolean('show_country')->default(1);
            $table->boolean('show_mobile_number')->default(1);
            $table->boolean('show_alternate_number')->default(0);
            $table->boolean('show_email')->default(0);
            $table->boolean('show_tax_1')->default(1);
            $table->boolean('show_tax_2')->default(0);
            $table->boolean('show_barcode')->default(0);
            
            $table->string('highlight_color', 10)->nullable();
            $table->text('footer_text')->nullable();
            $table->boolean('is_default')->default(0);
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_layouts');
    }
}
