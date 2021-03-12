<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Business;
use App\NotificationTemplate;

class AddDefaultNotificationTemplatesToDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $businesses = Business::get();

        $notification_template_data = [];
        foreach ($businesses as $business) {
            $notification_templates = NotificationTemplate::defaultNotificationTemplates($business->id);
            NotificationTemplate::insert($notification_templates);
        }
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
