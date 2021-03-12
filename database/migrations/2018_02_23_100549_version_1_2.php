<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

class Version12 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = \Carbon::now()->toDateTimeString();
        Permission::insert([
                [
                    'name' => 'profit_loss_report.view',
                    'guard_name' => 'web',
                    'created_at' => $now
                ],
                [
                    'name' => 'direct_sell.access',
                    'guard_name' => 'web',
                    'created_at' => $now
                ]
            ]);
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
