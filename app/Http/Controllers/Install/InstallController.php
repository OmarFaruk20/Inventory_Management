<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

use App\Utils\InstallUtil;
use Illuminate\Support\Facades\DB;
use Composer\Semver\Comparator;

//use Illuminate\Support\Facades\Storage;

class InstallController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $outputLog;
    protected $appVersion;
    protected $macActivationKeyChecker;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->appVersion = config('author.app_version');
        $this->env = config('app.env');

        //Check if mac based activation key is required or not.
        $this->macActivationKeyChecker = false;
        if (file_exists(__DIR__ . '/MacActivationKeyChecker.php')) {
            include_once(__DIR__ . '/MacActivationKeyChecker.php');
            $this->macActivationKeyChecker = $mac_is_enabled;
        }

        $this->installSettings();
    }

    /**
     * Initialize all install functions
     *
     */
    private function installSettings()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Check if project is already installed then show 404 error
     *
     */
    private function isInstalled()
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            abort(404);
        }
    }

    /**
     * This function deletes .env file.
     *
     */
    private function deleteEnv()
    {
        $envPath = base_path('.env');
        if ($envPath && file_exists($envPath)) {
            unlink($envPath);
        }
        return true;
    }

    /**
     * Installation
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Check for .env file
        $this->isInstalled();
        $this->installSettings();

        return view('install.index');
    }

    public function checkServer()
    {
        //Check for .env file
        $this->isInstalled();
        $this->installSettings();

        $output = [];
        
        //Check for php version
        $output['php'] = (PHP_MAJOR_VERSION >= 7 && PHP_MINOR_VERSION >=1) ? true : false;
        $output['php_version'] = PHP_VERSION;

        //Check for php extensions
        $output['openssl'] = extension_loaded('openssl') ? true : false;
        $output['pdo'] = extension_loaded('pdo') ? true : false;
        $output['mbstring'] = extension_loaded('mbstring') ? true : false;
        $output['tokenizer'] = extension_loaded('tokenizer') ? true : false;
        $output['xml'] = extension_loaded('xml') ? true : false;
        $output['curl'] = extension_loaded('curl') ? true : false;
        $output['zip'] = extension_loaded('zip') ? true : false;
        $output['gd'] = extension_loaded('gd') ? true : false;

        //Check for writable permission. storage and the bootstrap/cache directories should be writable by your web server
        $output['storage_writable'] = is_writable(storage_path());
        $output['cache_writable'] = is_writable(base_path('bootstrap/cache'));
        
        $output['next'] = $output['php'] && $output['openssl'] && $output['pdo'] && $output['mbstring'] && $output['tokenizer'] && $output['xml'] && $output['curl'] && $output['zip'] && $output['gd'] && $output['storage_writable'] && $output['cache_writable'];

        return view('install.check-server')
            ->with(compact('output'));
    }

    public function details()
    {
        //Check for .env file
        $this->isInstalled();
        $this->installSettings();

        //Check if .env.example is present or not.
        $env_example = base_path('.env.example');
        if (!file_exists($env_example)) {
            die("<b>.env.example file not found in <code>$env_example</code></b> <br/><br/> - In the downloaded codebase you will find .env.example file, please upload it and refresh this page.");
        }

        return view('install.details')
            ->with('activation_key', $this->macActivationKeyChecker);
    }

    public function postDetails(Request $request)
    {
        //Check for .env file
        $this->isInstalled();
        $this->installSettings();

        try {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');
            
            $validatedData = $request->validate(
                [
                'APP_NAME' => 'required',
                'ENVATO_PURCHASE_CODE' => 'required',
                'DB_DATABASE' => 'required',
                'DB_USERNAME' => 'required',
                'DB_PASSWORD' => 'required',
                'DB_HOST' => 'required',
                'DB_PORT' => 'required'
                ],
                [
                    'APP_NAME.required' => 'App Name is required',
                    'ENVATO_PURCHASE_CODE.required' => 'Envaot Purchase code is required',
                    'DB_DATABASE.required' => 'Database Name is required',
                    'DB_USERNAME.required' => 'Database Username is required',
                    'DB_PASSWORD.required' => 'Database Password is required',
                    'DB_HOST.required' => 'Database Host is required',
                    'DB_PORT.required' => 'Database port is required',
                ]
            );

            $this->outputLog = new BufferedOutput;

            $input = $request->only(['APP_NAME', 'APP_TITLE', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'ENVATO_PURCHASE_CODE',
                'ENVATO_EMAIL', 'ENVATO_USERNAME', 'MAIL_DRIVER',
                'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_ENCRYPTION',
                'MAIL_USERNAME', 'MAIL_PASSWORD']);

            $input['APP_DEBUG'] = "false";
            $input['APP_URL'] = url("/");
            $input['APP_ENV'] = 'live';

            //Check for database details
            $mysql_link = @mysqli_connect($input['DB_HOST'], $input['DB_USERNAME'], $input['DB_PASSWORD'], $input['DB_DATABASE'], $input['DB_PORT']);
            if (mysqli_connect_errno()) {
                $msg = "<b>ERROR</b>: Failed to connect to MySQL: " . mysqli_connect_error();
                $msg .= "<br/>Provide correct details for 'Database Host', 'Database Port', 'Database Name', 'Database Username', 'Database Password'.";
                return redirect()
                    ->back()
                    ->with('error', $msg);
            }

            //pos boot
            $return = pos_boot($input['APP_URL'], __DIR__, $input['ENVATO_PURCHASE_CODE'], $input['ENVATO_EMAIL'], $input['ENVATO_USERNAME']);
            if (!empty($return)) {
                return $return;
            }

            //Check for activation key
            if ($this->macActivationKeyChecker) {
                $licence_code = $request->get('MAC_LICENCE_CODE');
                $licence_valid = mac_verify_licence_code($licence_code);
                if (!$licence_valid) {
                    return redirect()->back()
                        ->with('error', 'Invalid Activation Licence Code!!')
                        ->withInput();
                    die('Invalid Purchase Code');
                }

                $input['MAC_LICENCE_CODE'] = $licence_code;
            }

            //Get .env file details and write the contents in it.
            $envPathExample = base_path('.env.example');
            $envPath = base_path('.env');

            $env_lines = file($envPathExample);
            foreach ($input as $index => $value) {
                foreach ($env_lines as $key => $line) {
                    //Check if present then replace it.
                    if (strpos($line, $index) !== false) {
                        $env_lines[$key] = $index . '="' . $value . '"' . PHP_EOL;
                    }
                }
            }
            
            //TODO: Remove false & automate the process of creating .env file.
            if (false) {
                // $fp = fopen($envPath, 'w');
                // fwrite($fp, implode('', $env_lines));
                // fclose($fp);

                // //Artisan commands
                // $this->runArtisanCommands();

                // return redirect()->route('install.success');
            } else {
                $this->deleteEnv();

                //Show intermediate steps if not able to copy file.
                $envContent = implode('', $env_lines);
                return view('install.envText')
                    ->with(compact('envContent'));
            }
        } catch (Exception $e) {
            $this->deleteEnv();

            return redirect()->back()
                ->with('error', 'Something went wrong, please try again!!');
        }
    }

    //Generate key, migrate and seed
    private function runArtisanCommands()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->installSettings();
        
        DB::statement('SET default_storage_engine=INNODB;');
        Artisan::call('migrate:fresh', ["--force"=> true]);
        Artisan::call('db:seed');
        //Artisan::call('storage:link');
    }

    public function installAlternate(Request $request)
    {
        try {
            $this->installSettings();

            //Check if no .env file than redirect back.
            $envPath = base_path('.env');
            if (!file_exists($envPath)) {
                return redirect()->route('install.details')
                    ->with('error', 'Looks like you haven\'t created the .env file ' . $envPath);
            }

            $this->runArtisanCommands();
            return redirect()->route('install.success');
        } catch (Exception $e) {
            $this->deleteEnv();

            return redirect()->back()
                ->with('error', 'Something went wrong, please try again!!');
        }
    }

    public function success()
    {
        return view('install.success');
    }

    public function updateConfirmation()
    {
        $installUtil = new installUtil();
        $db_version = $installUtil->getSystemInfo('db_version');
        
        if (Comparator::greaterThan($this->appVersion, $db_version)) {
            return view('install.update_confirmation');
        } else {
            abort(404);
        }
    }

    //Updating
    public function update(Request $request)
    {
        //Check if db_version is same as app_verison then 404
        //If app_version > db_version - run update script.
        //Else there is some problem.

        $version = null;

        try {
            DB::beginTransaction();

            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');

            $input = $request->only(['ENVATO_PURCHASE_CODE', 'ENVATO_USERNAME', 'ENVATO_EMAIL']);
            $return = pos_boot(config('app.url'), __DIR__, $input['ENVATO_PURCHASE_CODE'], $input['ENVATO_EMAIL'], $input['ENVATO_USERNAME'], 1);
            if (!empty($return)) {
                return $return;
            }

            //Static version value is passed for 1.2 version.
            if ($version == 1.2) {
                die("Update not supported. Kindly install again.");
            } elseif (is_null($version)) {
                $installUtil = new installUtil();
                $db_version = $installUtil->getSystemInfo('db_version');

                //if($db_version < $this->appVersion){
                if (Comparator::greaterThan($this->appVersion, $db_version)) {
                    ini_set('max_execution_time', 0);
                    ini_set('memory_limit', '512M');
                    $this->installSettings();
                    DB::statement('SET default_storage_engine=INNODB;');
                    Artisan::call('migrate', ["--force"=> true]);

                    $installUtil->setSystemInfo('db_version', $this->appVersion);

                    //If changed from v 1.3 to 2.0 then run this script.
                    $installUtil->updateFrom13To20($db_version, $this->appVersion);
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }

            DB::commit();
            
            $output = ['success' => 1,
                        'msg' => 'Updated Succesfully to version ' . $this->appVersion . ' !!'
                    ];
            return redirect('login')->with('status', $output);
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
