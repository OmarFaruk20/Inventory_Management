<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterDecimalFieldsSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE business MODIFY COLUMN default_sales_discount DECIMAL(20,2)");

        DB::statement("ALTER TABLE transactions MODIFY COLUMN total_before_tax DECIMAL(20,2) NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE transactions MODIFY COLUMN tax_amount DECIMAL(20,2) NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE transactions MODIFY COLUMN shipping_charges DECIMAL(20,2) NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE transactions MODIFY COLUMN final_total DECIMAL(20,2) NOT NULL 
            DEFAULT 0");
        DB::statement("ALTER TABLE transactions MODIFY COLUMN exchange_rate DECIMAL(20,2) NOT NULL 
            DEFAULT 1");

        DB::statement("ALTER TABLE variations MODIFY COLUMN default_purchase_price DECIMAL(20,2)");
        DB::statement("ALTER TABLE variations MODIFY COLUMN dpp_inc_tax DECIMAL(20,2) NOT NULL 
            DEFAULT 0");
        DB::statement("ALTER TABLE variations MODIFY COLUMN profit_percent DECIMAL(20,2) NOT NULL 
            DEFAULT 0");
        DB::statement("ALTER TABLE variations MODIFY COLUMN default_sell_price DECIMAL(20,2)");
        DB::statement("ALTER TABLE variations MODIFY COLUMN sell_price_inc_tax DECIMAL(20,2)");

        DB::statement("ALTER TABLE purchase_lines MODIFY COLUMN purchase_price DECIMAL(20,2)");
        DB::statement("ALTER TABLE purchase_lines MODIFY COLUMN purchase_price_inc_tax DECIMAL(20,2) NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE purchase_lines MODIFY COLUMN item_tax DECIMAL(20,2)");

        DB::statement("ALTER TABLE transaction_sell_lines MODIFY COLUMN unit_price DECIMAL(20,2)");
        DB::statement("ALTER TABLE transaction_sell_lines MODIFY COLUMN unit_price_inc_tax DECIMAL(20,2)");
        DB::statement("ALTER TABLE transaction_sell_lines MODIFY COLUMN item_tax DECIMAL(20,2)");

        DB::statement("ALTER TABLE cash_registers MODIFY COLUMN closing_amount DECIMAL(20,2) NOT NULL DEFAULT 0");

        DB::statement("ALTER TABLE variation_location_details MODIFY COLUMN qty_available DECIMAL(20,2)");
        
        DB::statement("ALTER TABLE transaction_payments MODIFY COLUMN amount DECIMAL(20,2) NOT NULL DEFAULT 0");

        DB::statement("ALTER TABLE cash_register_transactions MODIFY COLUMN amount DECIMAL(20,2) NOT NULL DEFAULT 0");
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
