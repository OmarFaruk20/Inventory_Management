<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\BusinessLocation;
use App\Contact;
use App\User;

use App\Restaurant\Booking;
use App\Restaurant\ResTable;

use DB;
use Yajra\DataTables\Facades\DataTables;

use App\Utils\Util;

class BookingController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('crud_all_bookings') && !auth()->user()->can('crud_own_bookings')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $user_id = request()->session()->get('user.id');

        if (request()->ajax()) {
            $start_date = request()->start;
            $end_date = request()->end;
            $query = Booking::where('business_id', $business_id)
                            ->whereBetween(DB::raw('date(booking_start)'), [$start_date, $end_date])
                            ->with(['customer', 'table']);

            if (!auth()->user()->hasPermissionTo('crud_all_bookings') && !$this->commonUtil->is_admin(auth()->user(), $business_id)) {
                $query->where('created_by', $user_id);
            }

            if (!empty(request()->location_id)) {
                $query->where('business_id', request()->location_id);
            }
            $bookings = $query->get();

            $events = [];

            foreach ($bookings as $booking) {
                $customer_name = $booking->customer->name;
                $table_name = optional($booking->table)->name;

                $backgroundColor = '#3c8dbc';
                $borderColor = '#3c8dbc';
                if ($booking->booking_status == 'completed') {
                    $backgroundColor = '#00a65a';
                    $borderColor = '#00a65a';
                } elseif ($booking->booking_status == 'cancelled') {
                    $backgroundColor = '#f56954';
                    $borderColor = '#f56954';
                }
                $title = $customer_name;
                if (!empty($table_name)) {
                    $title .= ' - ' . $table_name;
                }
                $events[] = [
                        'title' => $title,
                        'start' => $booking->booking_start,
                        'end' => $booking->booking_end,
                        'customer_name' => $customer_name,
                        'table' => $table_name,
                        'url' => action('Restaurant\BookingController@show', [ $booking->id ]),
                        // 'start_time' => $start_time,
                        // 'end_time' =>  $end_time,
                        'backgroundColor' => $backgroundColor,
                        'borderColor'     => $borderColor,
                        // 'allDay'          => true
                    ];
            }
            
            return $events;
        }

        $business_locations = BusinessLocation::forDropdown($business_id);

        $customers =  Contact::customersDropdown($business_id, false);

        $correspondents = User::forDropdown($business_id, false);

        return view('restaurant.booking.index', compact('business_locations', 'customers', 'correspondents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('crud_all_bookings') && !auth()->user()->can('crud_own_bookings')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            if ($request->ajax()) {
                $business_id = request()->session()->get('user.business_id');
                $user_id = request()->session()->get('user.id');

                $input = $request->input();
                $booking_start = $this->commonUtil->uf_date($input['booking_start'], true);
                $booking_end = $this->commonUtil->uf_date($input['booking_end'], true);
                $date_range = [$booking_start, $booking_end];

                //Check if booking is available for the required input
                $existing_booking = Booking::where('business_id', $business_id)
                                    ->where('location_id', $input['location_id'])
                                    ->where('table_id', $input['res_table_id'])
                                    ->where(function ($q) use ($date_range) {
                                        $q->whereBetween('booking_start', $date_range)
                                        ->orWhereBetween('booking_end', $date_range);
                                    })
                                    ->first();
                if (empty($existing_booking)) {
                    $data = [
                        'contact_id' => $input['contact_id'],
                        'waiter_id' => isset($input['res_waiter_id']) ? $input['res_waiter_id'] : null,
                        'table_id' => isset($input['res_table_id']) ? $input['res_table_id'] : null,
                        'business_id' => $business_id,
                        'location_id' => $input['location_id'],
                        'correspondent_id' => $input['correspondent'],
                        'booking_start' => $booking_start,
                        'booking_end' => $booking_end,
                        'created_by' => $user_id,
                        'booking_status' => 'booked',
                        'booking_note' => $input['booking_note']
                    ];
                    $booking = Booking::create($data);
                    $output = ['success' => 1,
                        'msg' => trans("lang_v1.added_success"),
                    ];

                    //Send notification to customer
                    if (isset($input['send_notification']) && $input['send_notification'] == 1) {
                        $output['send_notification'] = 1;
                        $output['notification_url'] = action('NotificationController@getTemplate', ["transaction_id" => $booking->id,"template_for" => "new_booking"]);
                    }
                } else {
                    $time_range = $this->commonUtil->format_date($existing_booking->booking_start, true) . ' ~ ' .
                                    $this->commonUtil->format_date($existing_booking->booking_end, true);

                    $output = ['success' => 0,
                            'msg' => trans(
                                "restaurant.booking_not_available",
                                ['customer_name' => $existing_booking->customer->name,
                                'booking_time_range' => $time_range]
                            )
                        ];
                }
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' => "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage()
                        ];
        }
        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $booking = Booking::where('business_id', $business_id)
                                ->where('id', $id)
                                ->with(['table', 'customer', 'correspondent', 'waiter', 'location'])
                                ->first();
            if (!empty($booking)) {
                $booking_start = $this->commonUtil->format_date($booking->booking_start, true);
                $booking_end = $this->commonUtil->format_date($booking->booking_end, true);

                $booking_statuses = [
                    'booked' => __('restaurant.booked'),
                    'completed' => __('restaurant.completed'),
                    'cancelled' => __('restaurant.cancelled'),
                ];
                return view('restaurant.booking.show', compact('booking', 'booking_start', 'booking_end', 'booking_statuses'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('crud_all_bookings') && !auth()->user()->can('crud_own_bookings')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $business_id = $request->session()->get('user.business_id');
            $booking = Booking::where('business_id', $business_id)
                                ->find($id);
            if (!empty($booking)) {
                $booking->booking_status = $request->booking_status;
                $booking->save();
            }

            $output = ['success' => 1,
                            'msg' => trans("lang_v1.updated_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }
        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('crud_all_bookings') && !auth()->user()->can('crud_own_bookings')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $business_id = request()->session()->get('user.business_id');
            $booking = Booking::where('business_id', $business_id)
                                ->where('id', $id)
                                ->delete();
            $output = ['success' => 1,
                            'msg' => trans("lang_v1.deleted_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }
        return $output;
    }

    /**
     * Retrieves todays bookings
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function getTodaysBookings()
    {
        if (!auth()->user()->can('crud_all_bookings') && !auth()->user()->can('crud_own_bookings')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');
            $today = \Carbon::now()->format('Y-m-d');
            $query = Booking::where('business_id', $business_id)
                                ->where('booking_status', 'booked')
                                ->whereDate('booking_start', $today)
                                ->with(['table', 'customer', 'correspondent', 'waiter', 'location']);

            if (!empty(request()->location_id)) {
                $query->where('location_id', request()->location_id);
            }

            if (!auth()->user()->hasPermissionTo('crud_all_bookings') && !$this->commonUtil->is_admin(auth()->user(), $business_id)) {
                $query->where('created_by', $user_id);
            }

            return Datatables::of($query)
                ->editColumn('table', function ($row) {
                    return !empty($row->table->name) ? $row->table->name : '--';
                })
                ->editColumn('customer', function ($row) {
                    return !empty($row->customer->name) ? $row->customer->name : '--';
                })
                ->editColumn('correspondent', function ($row) {
                    return !empty($row->correspondent->user_full_name) ? $row->correspondent->user_full_name : '--';
                })
                ->editColumn('waiter', function ($row) {
                    return !empty($row->waiter->user_full_name) ? $row->waiter->user_full_name : '--';
                })
                ->editColumn('location', function ($row) {
                    return !empty($row->location->name) ? $row->location->name : '--';
                })
                ->editColumn('booking_start', function ($row) {
                    return $this->commonUtil->format_date($row->booking_start, true);
                })
                ->editColumn('booking_end', function ($row) {
                    return $this->commonUtil->format_date($row->booking_end, true);
                })
               ->removeColumn('id')
                ->make(true);
        }
    }
}
