<?php
namespace App\Utils;

use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;

use App\Transaction;
use App\BusinessLocation;
use App\User;
use App\TransactionSellLine;

class RestaurantUtil
{
    /**
     * Retrieves all orders/sales
     *
     * @param int $business_id
     * @param array $filter
     * *For new orders order_status is 'received'
     *
     * @return obj $orders
     */
    public function getAllOrders($business_id, $filter = [])
    {
        $query = Transaction::leftJoin('contacts', 'transactions.contact_id', '=', 'contacts.id')
                ->leftjoin(
                    'business_locations AS bl',
                    'transactions.location_id',
                    '=',
                    'bl.id'
                )
                ->leftjoin(
                    'res_tables AS rt',
                    'transactions.res_table_id',
                    '=',
                    'rt.id'
                )
                ->where('transactions.business_id', $business_id)
                ->where('transactions.type', 'sell')
                ->where('transactions.status', 'final');
        // ->where('transactions.res_order_status', '!=' ,'served');

        if (empty($filter['order_status'])) {
            $query->where(function ($q) {
                $q->where('res_order_status', '!=', 'served')
                ->orWhereNull('res_order_status');
            });
        }

        //For new orders order_status is 'received'
        if (!empty($filter['order_status']) && $filter['order_status'] == 'received') {
            $query->whereNull('res_order_status');
        }

        if (!empty($filter['waiter_id'])) {
            $query->where('transactions.res_waiter_id', $filter['waiter_id']);
        }
                
        $orders =  $query->select(
            'transactions.*',
            'contacts.name as customer_name',
            'bl.name as business_location',
            'rt.name as table_name'
        )
                ->orderBy('created_at', 'desc')
                ->get();

        return $orders;
    }

    public function service_staff_dropdown($business_id)
    {
        //Get all service staff roles
        $service_staff_roles = Role::where('business_id', $business_id)
                                ->where('is_service_staff', 1)
                                ->get()
                                ->pluck('name')
                                ->toArray();

        $service_staff = [];

        //Get all users of service staff roles
        if (!empty($service_staff_roles)) {
            $service_staff = User::where('business_id', $business_id)->role($service_staff_roles)->get()->pluck('first_name', 'id');
        }

        return $service_staff;
    }

    public function is_service_staff($user_id)
    {
        $is_service_staff = false;
        $user = User::find($user_id);
        if ($user->roles->first()->is_service_staff == 1) {
            $is_service_staff = true;
        }

        return $is_service_staff;
    }

    /**
     * Retrieves line orders/sales
     *
     * @param int $business_id
     * @param array $filter
     * *For new orders order_status is 'received'
     *
     * @return obj $orders
     */
    public function getLineOrders($business_id, $filter = [])
    {
        $query = TransactionSellLine::leftJoin('transactions as t', 't.id', '=', 'transaction_sell_lines.transaction_id')
                ->leftJoin('contacts as c', 't.contact_id', '=', 'c.id')
                ->leftJoin('variations as v', 'transaction_sell_lines.variation_id', '=', 'v.id')
                ->leftJoin('products as p', 'v.product_id', '=', 'p.id')
                ->leftJoin('units as u', 'p.unit_id', '=', 'u.id')
                ->leftJoin('product_variations as pv', 'v.product_variation_id', '=', 'pv.id')
                ->leftjoin(
                    'business_locations AS bl',
                    't.location_id',
                    '=',
                    'bl.id'
                )
                ->leftjoin(
                    'res_tables AS rt',
                    't.res_table_id',
                    '=',
                    'rt.id'
                )
                ->where('t.business_id', $business_id)
                ->where('t.type', 'sell')
                ->where('t.status', 'final');

        if (empty($filter['order_status'])) {
            $query->where(function ($q) {
                $q->where('res_line_order_status', '!=', 'served')
                ->orWhereNull('res_line_order_status');
            });
        }

        if (!empty($filter['waiter_id'])) {
            $query->where('transaction_sell_lines.res_service_staff_id', $filter['waiter_id']);
        }
                
        $orders =  $query->select(
            'p.name as product_name',
            'p.type as product_type',
            'v.name as variation_name',
            'pv.name as product_variation_name',
            't.id as transaction_id',
            'c.name as customer_name',
            'bl.name as business_location',
            'rt.name as table_name',
            't.created_at',
            't.invoice_no',
            'transaction_sell_lines.quantity',
            'transaction_sell_lines.res_line_order_status',
            'u.short_name as unit',
            'transaction_sell_lines.id'
        )
                ->orderBy('created_at', 'desc')
                ->get();

        return $orders;
    }
}
