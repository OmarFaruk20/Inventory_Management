<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyUsersTableForSalesCmmsnAgnt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN surname CHAR(10)");

        Schema::table('users', function (Blueprint $table) {
            $table->char('contact_no', 15)->nullable()->after('language');
            $table->text('address')->nullable()->after('contact_no');
            $table->boolean('is_cmmsn_agnt')->default(0)->after('business_id');
            $table->decimal('cmmsn_percent', 4, 2)->default(0)->after('is_cmmsn_agnt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
