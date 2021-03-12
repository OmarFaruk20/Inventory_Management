<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyTransactionsTableForExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('purchase','sell', 'expense')");
        DB::statement("ALTER TABLE transactions MODIFY COLUMN contact_id INT(11) UNSIGNED DEFAULT NULL");

        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('expense_category_id')->nullable()->unsigned()->after('final_total');
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('cascade');
            $table->integer('expense_for')->nullable()->unsigned()->after('expense_category_id');
            $table->foreign('expense_for')->references('id')->on('users')->onDelete('cascade');

            $table->index('expense_category_id');
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
            //
        });
    }
}
