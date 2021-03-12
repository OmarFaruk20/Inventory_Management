<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuotationRelatedChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('is_quotation')->after('status')->default(false);
        });

        Schema::table('invoice_layouts', function (Blueprint $table) {
            $table->string('quotation_heading')->after('invoice_heading_paid')->nullable();
            $table->string('quotation_no_prefix')->after('invoice_no_prefix')->nullable();
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
            $table->dropColumn('is_quotation');
        });

        Schema::table('invoice_layouts', function (Blueprint $table) {
            $table->dropColumn('quotation_heading');
            $table->dropColumn('quotation_no_prefix');
        });
    }
}
