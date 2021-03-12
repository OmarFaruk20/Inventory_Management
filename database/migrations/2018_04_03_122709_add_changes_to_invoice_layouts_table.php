<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangesToInvoiceLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_layouts', function (Blueprint $table) {
            $table->string('sub_heading_line1')->nullable()->after('invoice_heading');
            $table->string('sub_heading_line2')->nullable()->after('sub_heading_line1');
            $table->string('sub_heading_line3')->nullable()->after('sub_heading_line2');
            $table->string('sub_heading_line4')->nullable()->after('sub_heading_line3');
            $table->string('sub_heading_line5')->nullable()->after('sub_heading_line4');

            $table->string('table_product_label')->nullable()->after('paid_label');
            $table->string('table_qty_label')->nullable()->after('table_product_label');
            $table->string('table_unit_price_label')->nullable()->after('table_qty_label');
            $table->string('table_subtotal_label')->nullable()->after('table_unit_price_label');

            $table->boolean('show_client_id')->default(0)->after('paid_label');
            $table->string('client_id_label')->nullable()->after('show_client_id');
            $table->string('date_label')->nullable()->after('client_id_label');
            $table->boolean('show_time')->default(1)->after('date_label');

            $table->boolean('show_brand')->default(0)->after('show_time');
            $table->boolean('show_sku')->default(1)->after('show_brand');
            $table->boolean('show_cat_code')->default(1)->after('show_sku');
            $table->boolean('show_sale_description')->default(0)->after('show_cat_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_layouts', function (Blueprint $table) {
            //
        });
    }
}
