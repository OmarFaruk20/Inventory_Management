<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use App\Utils\ModuleUtil;

use DB;

class CreateDummyBusiness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:dummyBusiness';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a dummy business in the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Drop database and create the db with same name.
        $servername = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $db = env('DB_DATABASE');
        $conn = mysqli_connect($servername, $username, $password);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        //Drop DB
        $delete_db = "DROP DATABASE $db";
        if (mysqli_query($conn, $delete_db)) {
            $create_db = "CREATE DATABASE $db";
            mysqli_query($conn, $create_db);
        } else {
            die("Error deleting db");
        }
        
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
        
        DB::beginTransaction();

        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        DB::statement('SET default_storage_engine=INNODB;');

        // DB::statement("DROP TABLE IF EXISTS barcodes, brands, business, business_locations, cash_registers, cash_register_transactions, categories, contacts, currencies, expense_categories, group_sub_taxes, invoice_layouts, invoice_schemes, migrations, model_has_permissions, model_has_roles, password_resets, permissions, printers, products, product_variations, purchase_lines, roles, role_has_permissions, sessions, stock_adjustment_lines, tax_rates, transactions, transaction_payments, transaction_sell_lines, units, users, variations, variation_location_details, variation_templates, variation_value_templates, transaction_sell_lines_purchase_lines");

        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        Artisan::call('cache:clear');
        Artisan::call('migrate', ["--force" => true]);
        Artisan::call('db:seed');
        Artisan::call('db:seed', ["--class" => 'DummyBusinessSeeder']);

        //Run the purchase & mapping command
        //Artisan::call('pos:mapPurchaseSell');
        
        //Call modules dummy
        $moduleUtil = new ModuleUtil();
        $moduleUtil->getModuleData('dummy_data');
        
        if (config('app.env') == 'demo') {
            system('chmod 777 -R /var/www/pos/storage');
        }

        DB::commit();
    }
}
