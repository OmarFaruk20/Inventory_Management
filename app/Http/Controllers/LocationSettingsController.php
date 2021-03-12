<?php

namespace App\Http\Controllers;

use App\BusinessLocation;
use App\Printer;
use App\InvoiceLayout;
use App\InvoiceScheme;

use Illuminate\Http\Request;

class LocationSettingsController extends Controller
{
    /**
    * All class instance.
    *
    */
    protected $printReceiptOnInvoice;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->printReceiptOnInvoice = ['1' => 'Yes', '0' => 'No'];
        $this->receiptPrinterType = ['browser' => 'Browser Based Printing', 'printer' => 'Use Configured Receipt Printer'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($location_id)
    {
        //Check for locations access permission
        if (!auth()->user()->can('business_settings.access') ||
            !auth()->user()->can_access_this_location($location_id)
        ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $location = BusinessLocation::where('business_id', $business_id)
                        ->findorfail($location_id);

        $printers = Printer::forDropdown($business_id);

        $printReceiptOnInvoice = $this->printReceiptOnInvoice;
        $receiptPrinterType = $this->receiptPrinterType;

        $invoice_layouts = InvoiceLayout::where('business_id', $business_id)
                            ->get()
                            ->pluck('name', 'id');
        $invoice_schemes = InvoiceScheme::where('business_id', $business_id)
                            ->get()
                            ->pluck('name', 'id');

        return view('location_settings.index')
            ->with(compact('location', 'printReceiptOnInvoice', 'receiptPrinterType', 'printers', 'invoice_layouts', 'invoice_schemes'));
    }

    /**
     * Update the settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings($location_id, Request $request)
    {
        try {
            //Check for locations access permission
            if (!auth()->user()->can('business_settings.access') ||
                !auth()->user()->can_access_this_location($location_id)
            ) {
                abort(403, 'Unauthorized action.');
            }
            
            $input = $request->only(['print_receipt_on_invoice', 'receipt_printer_type', 'printer_id', 'invoice_layout_id', 'invoice_scheme_id']);

            //Auto set to browser in demo.
            if (config('app.env') == 'demo') {
                $input['receipt_printer_type'] = 'browser';
            }

            $business_id = request()->session()->get('user.business_id');

            $location = BusinessLocation::where('business_id', $business_id)
                            ->findorfail($location_id);

            $location->fill($input);
            $location->update();

            $output = ['success' => 1,
                        'msg' => __("receipt.receipt_settings_updated")
                    ];
        } catch (\Exception $e) {
            $output = ['success' => 0,
                        'msg' => __("messages.something_went_wrong")
                    ];
        }

        return back()->with('status', $output);
    }
}
