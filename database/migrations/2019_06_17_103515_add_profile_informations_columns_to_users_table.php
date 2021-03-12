<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileInformationsColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->nullable()->after('selected_contacts');
            $table->enum('marital_status', ['married', 'unmarried', 'divorced'])->nullable()->after('dob');
            $table->char('blood_group', 10)->nullable()->after('marital_status');
            $table->char('contact_number', 20)->nullable()->after('blood_group');
            $table->string('fb_link')->nullable()->after('contact_number');
            $table->string('twitter_link')->nullable()->after('fb_link');
            $table->string('social_media_1')->nullable()->after('twitter_link');
            $table->string('social_media_2')->nullable()->after('social_media_1');
            $table->text('permanent_address')->nullable()->after('social_media_2');
            $table->text('current_address')->nullable()->after('permanent_address');
            $table->string('guardian_name')->nullable()->after('current_address');
            $table->string('custom_field_1')->nullable()->after('guardian_name');
            $table->string('custom_field_2')->nullable()->after('custom_field_1');
            $table->string('custom_field_3')->nullable()->after('custom_field_2');
            $table->string('custom_field_4')->nullable()->after('custom_field_3');
            $table->longText('bank_details')->nullable()->after('custom_field_4');
            $table->string('id_proof_name')->nullable()->after('bank_details');
            $table->string('id_proof_number')->nullable()->after('id_proof_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
