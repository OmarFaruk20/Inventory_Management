<?php

namespace App\Http\Controllers;

use App\Business;
use App\Currency;
use App\System;
use App\TaxRate;
use App\Unit;
use App\User;
use App\Utils\BusinessUtil;

use App\Utils\ModuleUtil;
use App\Utils\RestaurantUtil;
use Carbon\Carbon;
use DateTimeZone;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;

class BusinessController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BusinessController
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new business/business as well as their
    | validation and creation.
    |
    */

    /**
     * All Utils instance.
     *
     */
    protected $businessUtil;
    protected $restaurantUtil;
    protected $moduleUtil;
    protected $mailDrivers;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(BusinessUtil $businessUtil, RestaurantUtil $restaurantUtil, ModuleUtil $moduleUtil)
    {
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;

        $this->avlble_modules = [
            'tables' => [ 'name' => __('restaurant.tables'),
                        'tooltip' => __('restaurant.tooltip_tables')
                    ] ,
            'modifiers' => [ 'name' => __('restaurant.modifiers'),
                    'tooltip' => __('restaurant.tooltip_modifiers')
                ],
            'service_staff' => [
                    'name' => __('restaurant.service_staff'),
                    'tooltip' => __('restaurant.tooltip_service_staff')
                ],
            'kitchen' => [
                'name' => __('restaurant.kitchen_for_restaurant')
            ],
            'account' => ['name' => __('lang_v1.account')],
            'subscription' => ['name' => __('lang_v1.enable_subscription')]
        ];
        
        $this->theme_colors = [
            'blue' => 'Blue',
            'black' => 'Black',
            'purple' => 'Purple',
            'green' => 'Green',
            'red' => 'Red',
            'yellow' => 'Yellow',
            'blue-light' => 'Blue Light',
            'black-light' => 'Black Light',
            'purple-light' => 'Purple Light',
            'green-light' => 'Green Light',
            'red-light' => 'Red Light',
        ];

        $this->mailDrivers = [
                'smtp' => 'SMTP',
                'sendmail' => 'Sendmail',
                'mailgun' => 'Mailgun',
                'mandrill' => 'Mandrill',
                'ses' => 'SES',
                'sparkpost' => 'Sparkpost'
            ];
    }

    /**
     * Shows registration form
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        if (!env('ALLOW_REGISTRATION', true)) {
            return redirect('/');
        }

        $currencies = $this->businessUtil->allCurrencies();

        
        $timezone_list = $this->businessUtil->allTimeZones();

        $months = [];
        for ($i=1; $i<=12; $i++) {
            $months[$i] = __('business.months.' . $i);
        }

        $accounting_methods = $this->businessUtil->allAccountingMethods();
        $package_id = request()->package;

        $system_settings = System::getProperties(['superadmin_enable_register_tc', 'superadmin_register_tc'], true);
        
        return view('business.register', compact(
            'currencies',
            'timezone_list',
            'months',
            'accounting_methods',
            'package_id',
            'system_settings'
        ));
    }

    /**
     * Handles the registration of a new business and it's owner
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        if (!env('ALLOW_REGISTRATION', true)) {
            return redirect('/');
        }
        
        try {
            $validator = $request->validate(
                [
                'name' => 'required|max:255',
                'currency_id' => 'required|numeric',
                'country' => 'required|max:255',
                'state' => 'required|max:255',
                'city' => 'required|max:255',
                'zip_code' => 'required|max:255',
                'landmark' => 'required|max:255',
                'time_zone' => 'required|max:255',
                'surname' => 'max:10',
                'email' => 'sometimes|nullable|email|unique:users|max:255',
                'first_name' => 'required|max:255',
                'username' => 'required|min:4|max:255|unique:users',
                'password' => 'required|min:4|max:255',
                'fy_start_month' => 'required',
                'accounting_method' => 'required',
                ],
                [
                'name.required' => __('validation.required', ['attribute' => __('business.business_name')]),
                'name.currency_id' => __('validation.required', ['attribute' => __('business.currency')]),
                'country.required' => __('validation.required', ['attribute' => __('business.country')]),
                'state.required' => __('validation.required', ['attribute' => __('business.state')]),
                'city.required' => __('validation.required', ['attribute' => __('business.city')]),
                'zip_code.required' => __('validation.required', ['attribute' => __('business.zip_code')]),
                'landmark.required' => __('validation.required', ['attribute' => __('business.landmark')]),
                'time_zone.required' => __('validation.required', ['attribute' => __('business.time_zone')]),
                'email.email' => __('validation.email', ['attribute' => __('business.email')]),
                'email.email' => __('validation.unique', ['attribute' => __('business.email')]),
                'first_name.required' => __('validation.required', ['attribute' =>
                    __('business.first_name')]),
                'username.required' => __('validation.required', ['attribute' => __('business.username')]),
                'username.min' => __('validation.min', ['attribute' => __('business.username')]),
                'password.required' => __('validation.required', ['attribute' => __('business.username')]),
                'password.min' => __('validation.min', ['attribute' => __('business.username')]),
                'fy_start_month.required' => __('validation.required', ['attribute' => __('business.fy_start_month')]),
                'accounting_method.required' => __('validation.required', ['attribute' => __('business.accounting_method')]),
                ]
            );

            DB::beginTransaction();

            //Create owner.
            $owner_details = $request->only(['surname', 'first_name', 'last_name', 'username', 'email', 'password', 'language']);
            $user = User::create_user($owner_details);

            $business_details = $request->only(['name', 'start_date', 'currency_id', 'time_zone']);
            $business_details['fy_start_month'] = 1;

            $business_location = $request->only(['name', 'country', 'state', 'city', 'zip_code', 'landmark', 'website', 'mobile', 'alternate_number']);
            
            //Create the business
            $business_details['owner_id'] = $user->id;
            if (!empty($business_details['start_date'])) {
                $business_details['start_date'] = Carbon::createFromFormat('m/d/Y', $business_details['start_date'])->toDateString();
            }
            
            //upload logo
            $logo_name = $this->businessUtil->uploadFile($request, 'business_logo', 'business_logos');
            if (!empty($logo_name)) {
                $business_details['logo'] = $logo_name;
            }
            
            $business = $this->businessUtil->createNewBusiness($business_details);

            //Update user with business id
            $user->business_id = $business->id;
            $user->save();

            $this->businessUtil->newBusinessDefaultResources($business->id, $user->id);
            $new_location = $this->businessUtil->addLocation($business->id, $business_location);

            //create new permission with the new location
            Permission::create(['name' => 'location.' . $new_location->id ]);

            DB::commit();

            //Process payment information if superadmin is installed & package information is present
            $is_installed_superadmin = $this->moduleUtil->isSuperadminInstalled();
            $package_id = $request->get('package_id', null);
            if ($is_installed_superadmin && !empty($package_id) && (config('app.env') != 'demo')) {
                $package = \Modules\Superadmin\Entities\Package::find($package_id);
                if (!empty($package)) {
                    Auth::login($user);
                    return redirect()->route('register-pay', ['package_id' => $package_id]);
                }
            }

            $output = ['success' => 1,
                    'msg' => __('business.business_created_succesfully')
                ];

            return redirect('login')->with('status', $output);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage()
                        ];

            return back()->with('status', $output)->withInput();
        }
    }
    
    /**
     * Handles the validation username
     *
     * @return \Illuminate\Http\Response
     */
    public function postCheckUsername(Request $request)
    {
        $username = $request->input('username');

        if (!empty($request->input('username_ext'))) {
            $username .= $request->input('username_ext');
        }

        $count = User::where('username', $username)->count();
        if ($count == 0) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }
    
    /**
     * Shows business settings form
     *
     * @return \Illuminate\Http\Response
     */
    public function getBusinessSettings()
    {
        if (!auth()->user()->can('business_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $timezone_list = [];
        foreach ($timezones as $timezone) {
            $timezone_list[$timezone] = $timezone;
        }

        $business_id = request()->session()->get('user.business_id');
        $business = Business::where('id', $business_id)->first();
        
        $currencies = $this->businessUtil->allCurrencies();
        $tax_details = TaxRate::forBusinessDropdown($business_id);
        $tax_rates = $tax_details['tax_rates'];

        $months = [];
        for ($i=1; $i<=12; $i++) {
            $months[$i] = __('business.months.' . $i);
        }

        $accounting_methods = [
                'fifo' => __('business.fifo'),
                'lifo' => __('business.lifo')
            ];
        $commission_agent_dropdown = [
                '' => __('lang_v1.disable'),
                'logged_in_user' => __('lang_v1.logged_in_user'),
                'user' => __('lang_v1.select_from_users_list'),
                'cmsn_agnt' => __('lang_v1.select_from_commisssion_agents_list')
            ];

        $units_dropdown = Unit::forDropdown($business_id, true);

        $date_formats = Business::date_formats();

        $shortcuts = json_decode($business->keyboard_shortcuts, true);
        
        if (empty($business->pos_settings)) {
            $pos_settings = $this->businessUtil->defaultPosSettings();
        } else {
            $pos_settings = json_decode($business->pos_settings, true);
        }

        $email_settings = [];
        if (empty($business->email_settings)) {
            $email_settings = $this->businessUtil->defaultEmailSettings();
        } else {
            $email_settings = $business->email_settings;
        }

        $sms_settings = [];
        if (empty($business->sms_settings)) {
            $sms_settings = $this->businessUtil->defaultSmsSettings();
        } else {
            $sms_settings = $business->sms_settings;
        }

        $modules = $this->avlble_modules;

        $theme_colors = $this->theme_colors;

        $mail_drivers = $this->mailDrivers;

        $allow_superadmin_email_settings = System::getProperty('allow_email_settings_to_businesses');

        return view('business.settings', compact('business', 'currencies', 'tax_rates', 'timezone_list', 'months', 'accounting_methods', 'commission_agent_dropdown', 'units_dropdown', 'date_formats', 'shortcuts', 'pos_settings', 'modules', 'theme_colors', 'email_settings', 'sms_settings', 'mail_drivers', 'allow_superadmin_email_settings'));
    }

    /**
     * Updates business settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postBusinessSettings(Request $request)
    {
        if (!auth()->user()->can('business_settings.access')) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $business_details = $request->only(['name', 'start_date', 'currency_id', 'tax_label_1', 'tax_number_1', 'tax_label_2', 'tax_number_2', 'default_profit_percent', 'default_sales_tax', 'default_sales_discount', 'sell_price_tax', 'sku_prefix', 'time_zone', 'fy_start_month', 'accounting_method', 'transaction_edit_days', 'sales_cmsn_agnt', 'item_addition_method', 'currency_symbol_placement', 'on_product_expiry',
                'stop_selling_before', 'default_unit', 'expiry_type', 'date_format', 'time_format', 'ref_no_prefixes', 'theme_color', 'email_settings', 'sms_settings']);

            if (!empty($business_details['start_date'])) {
                $business_details['start_date'] = Carbon::createFromFormat('m/d/Y', $business_details['start_date'])->toDateString();
            }

            if (!empty($request->input('enable_tooltip')) &&  $request->input('enable_tooltip') == 1) {
                $business_details['enable_tooltip'] = 1;
            } else {
                $business_details['enable_tooltip'] = 0;
            }

            $business_details['enable_product_expiry'] = !empty($request->input('enable_product_expiry')) &&  $request->input('enable_product_expiry') == 1 ? 1 : 0;
            if ($business_details['on_product_expiry'] == 'keep_selling') {
                $business_details['stop_selling_before'] = null;
            }

            $business_details['stock_expiry_alert_days'] = !empty($request->input('stock_expiry_alert_days')) ? $request->input('stock_expiry_alert_days') : 30;

            //Check for Purchase currency
            if (!empty($request->input('purchase_in_diff_currency')) &&  $request->input('purchase_in_diff_currency') == 1) {
                $business_details['purchase_in_diff_currency'] = 1;
                $business_details['purchase_currency_id'] = $request->input('purchase_currency_id');
                $business_details['p_exchange_rate'] = $request->input('p_exchange_rate');
            } else {
                $business_details['purchase_in_diff_currency'] = 0;
                $business_details['purchase_currency_id'] = null;
                $business_details['p_exchange_rate'] = 1;
            }

            //upload logo
            $logo_name = $this->businessUtil->uploadFile($request, 'business_logo', 'business_logos');
            if (!empty($logo_name)) {
                $business_details['logo'] = $logo_name;
            }

            $checkboxes = ['enable_editing_product_from_purchase', 'enable_inline_tax',
                'enable_brand', 'enable_category', 'enable_sub_category', 'enable_price_tax', 'enable_purchase_status',
                'enable_lot_number', 'enable_racks', 'enable_row', 'enable_position'];
            foreach ($checkboxes as $value) {
                $business_details[$value] = !empty($request->input($value)) &&  $request->input($value) == 1 ? 1 : 0;
            }
            
            $business_id = request()->session()->get('user.business_id');
            $business = Business::where('id', $business_id)->first();

            //Update business settings
            if (!empty($business_details['logo'])) {
                $business->logo = $business_details['logo'];
            } else {
                unset($business_details['logo']);
            }

            //System settings
            $shortcuts = $request->input('shortcuts');
            $business_details['keyboard_shortcuts'] = json_encode($shortcuts);

            //pos_settings
            $pos_settings = $request->input('pos_settings');
            $default_pos_settings = $this->businessUtil->defaultPosSettings();
            foreach ($default_pos_settings as $key => $value) {
                if (!isset($pos_settings[$key])) {
                    $pos_settings[$key] = $value;
                }
            }
            $business_details['pos_settings'] = json_encode($pos_settings);

            //Enabled modules
            $enabled_modules = $request->input('enabled_modules');
            $business_details['enabled_modules'] = !empty($enabled_modules) ? $enabled_modules : null;

            $business->fill($business_details);
            $business->save();

            //update session data
            $request->session()->put('business', $business);

            //Update Currency details
            $currency = Currency::find($business->currency_id);
            $request->session()->put('currency', [
                        'id' => $currency->id,
                        'code' => $currency->code,
                        'symbol' => $currency->symbol,
                        'thousand_separator' => $currency->thousand_separator,
                        'decimal_separator' => $currency->decimal_separator,
                        ]);
            
            //update current financial year to session
            $financial_year = $this->businessUtil->getCurrentFinancialYear($business->id);
            $request->session()->put('financial_year', $financial_year);
            
            $output = ['success' => 1,
                            'msg' => __('business.settings_updated_success')
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
        }
        return redirect('business/settings')->with('status', $output);
    }

    /**
     * Handles the validation email
     *
     * @return \Illuminate\Http\Response
     */
    public function postCheckEmail(Request $request)
    {
        $email = $request->input('email');

        $query = User::where('email', $email);

        if (!empty($request->input('user_id'))) {
            $user_id = $request->input('user_id');
            $query->where('id', '!=', $user_id);
        }

        $exists = $query->exists();
        if (!$exists) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }
}
