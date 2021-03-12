<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeExchageRateSizeInBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE business MODIFY COLUMN p_exchange_rate DECIMAL(20, 3) NOT NULL DEFAULT 1");
        DB::statement("ALTER TABLE transactions MODIFY COLUMN exchange_rate DECIMAL(20,3) NOT NULL DEFAULT 1");

        //Update 0 to 1
        DB::table('transactions')
            ->where('exchange_rate', 0)
            ->update(['exchange_rate' => 1]);
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
