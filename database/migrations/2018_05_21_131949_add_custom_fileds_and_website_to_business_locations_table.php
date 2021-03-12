<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomFiledsAndWebsiteToBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->string('website')->nullable()->after('email');
            $table->string('custom_field1')->nullable()->after('website');
            $table->string('custom_field2')->nullable()->after('custom_field1');
            $table->string('custom_field3')->nullable()->after('custom_field2');
            $table->string('custom_field4')->nullable()->after('custom_field3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            //
        });
    }
}
