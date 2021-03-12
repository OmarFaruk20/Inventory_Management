<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLotNumberToBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->boolean('enable_lot_number')->after('enable_purchase_status')->default(false);
        });

        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->string('lot_number', 256)->after('exp_date')->nullable();
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
            $table->dropColumn('enable_lot_number');
        });

        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->dropColumn('lot_number');
        });
    }
}
