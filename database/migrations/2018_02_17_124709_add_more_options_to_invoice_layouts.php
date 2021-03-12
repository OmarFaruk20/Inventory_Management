<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreOptionsToInvoiceLayouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_layouts', function (Blueprint $table) {
            $table->string('invoice_heading_paid')->nullable()->after('invoice_heading');
            $table->string('invoice_heading_not_paid')->nullable()->after('invoice_heading');
            $table->string('total_due_label')->nullable()->after('total_label');
            $table->string('paid_label')->nullable()->after('total_due_label');
            $table->boolean('show_payments')->default(0)->after('show_barcode');
            $table->boolean('show_customer')->default(0)->after('show_payments');
            $table->string('customer_label')->nullable()->after('show_customer');
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
            $table->dropColumn('invoice_heading_paid');
            $table->dropColumn('invoice_heading_not_paid');
            $table->dropColumn('total_due_label');
            $table->dropColumn('paid_label');
            $table->dropColumn('show_payments');
            $table->dropColumn('show_customer');
            $table->dropColumn('customer_label');
        });
    }
}
