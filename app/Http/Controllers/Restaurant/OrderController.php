<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Transaction;
use App\User;
use App\TransactionSellLine;

use App\Utils\Util;
use App\Utils\RestaurantUtil;

class OrderController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $restUtil;

    /**
     * Constructor
     *
     * @param Util $commonUtil
     * @param RestaurantUtil $restUtil
     * @return void
     */
    public function __construct(Util $commonUtil, RestaurantUtil $restUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->restUtil = $restUtil;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // if (!auth()->user()->can('sell.view')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $business_id = request()->session()->get('user.business_id');
        $user_id = request()->session()->get('user.id');

        $is_service_staff = false;
        $orders = [];
        $service_staff = [];
        $line_orders = [];
        if ($this->restUtil->is_service_staff($user_id)) {
            $is_service_staff = true;
            $orders = $this->restUtil->getAllOrders($business_id, ['waiter_id' => $user_id]);

            $line_orders = $this->restUtil->getLineOrders($business_id, ['waiter_id' => $user_id]);
        } elseif (!empty(request()->service_staff)) {
            $orders = $this->restUtil->getAllOrders($business_id, ['waiter_id' => request()->service_staff]);

            $line_orders = $this->restUtil->getLineOrders($business_id, ['waiter_id' => request()->service_staff]);
        }

        if (!$is_service_staff) {
            $service_staff = $this->restUtil->service_staff_dropdown($business_id);
        }

        return view('restaurant.orders.index', compact('orders', 'is_service_staff', 'service_staff', 'line_orders'));
    }

    /**
     * Marks an order as served
     * @return json $output
     */
    public function markAsServed($id)
    {
        // if (!auth()->user()->can('sell.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
        try {
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');

            $transaction = Transaction::where('business_id', $business_id)
                            ->where('type', 'sell')
                            ->where('res_waiter_id', $user_id)
                            ->find($id);
            if (!empty($transaction)) {
                $transaction->res_order_status = 'served';
                $transaction->save();
                $output = ['success' => 1,
                            'msg' => trans("restaurant.order_successfully_marked_served")
                        ];
            } else {
                $output = ['success' => 0,
                            'msg' => trans("messages.something_went_wrong")
                        ];
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => trans("messages.something_went_wrong")
                        ];
        }

        return $output;
    }

    /**
     * Marks an line order as served
     * @return json $output
     */
    public function markLineOrderAsServed($id)
    {
        try {
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');

            $sell_line = TransactionSellLine::where('res_service_staff_id', $user_id)
                                    ->find($id);

            if (!empty($sell_line)) {
                $sell_line->res_line_order_status = 'served';
                $sell_line->save();
                $output = ['success' => 1,
                            'msg' => trans("restaurant.order_successfully_marked_served")
                        ];
            } else {
                $output = ['success' => 0,
                            'msg' => trans("messages.something_went_wrong")
                        ];
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => trans("messages.something_went_wrong")
                        ];
        }

        return $output;
    }
}
