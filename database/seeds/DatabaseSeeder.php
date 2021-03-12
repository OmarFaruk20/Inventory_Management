<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([BarcodesTableSeeder::class,
                    PermissionsTableSeeder::class,
                    CurrenciesTableSeeder::class
                    ]);
    }
}
