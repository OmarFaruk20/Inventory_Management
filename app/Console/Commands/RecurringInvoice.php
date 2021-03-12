<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Transaction;
use App\Contact;
use App\User;

use App\Utils\TransactionUtil;
use App\Utils\ProductUtil;
use App\Utils\NotificationUtil;

class RecurringInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:generateSubscriptionInvoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates subscribed invoices if enabled';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil, NotificationUtil $notificationUtil)
    {
        parent::__construct();

        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
        $this->notificationUtil = $notificationUtil;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');

            $transactions = Transaction::where('is_recurring', 1)
                                ->where('type', 'sell')
                                ->where('status', 'final')
                                ->whereNull('recur_stopped_on')
                                ->whereNotNull('recur_interval')
                                ->whereNotNull('recur_interval_type')
                                ->with(['recurring_invoices',
                                    'sell_lines', 'business',
                                    'sell_lines.product'])
                                ->get();

            DB::beginTransaction();

            foreach ($transactions as $transaction) {
                //Check if recurring invoice is enabled
                if (!empty($transaction->business->enabled_modules)
                    && !in_array('subscription', $transaction->business->enabled_modules)) {
                    continue;
                }

                //Check if no. of generated invoices exceed limit
                $no_of_recurring_invoice_generated = count($transaction->recurring_invoices);

                if (!empty($transaction->recur_repetitions) && $no_of_recurring_invoice_generated >= $transaction->recur_repetitions) {
                    continue;
                }

                //Check if generate interval is today
                $last_generated = $no_of_recurring_invoice_generated > 0 ? $transaction->recurring_invoices->max('transaction_date') : $transaction->transaction_date;

                if (!empty($last_generated)) {
                    $last_generated = \Carbon::createFromFormat('Y-m-d H:i:s', $last_generated);
                    $diff_from_today = 0;
                    if ($transaction->recur_interval_type == 'days') {
                        $diff_from_today = $last_generated->diffInDays();
                    } elseif ($transaction->recur_interval_type == 'months') {
                        $diff_from_today = $last_generated->diffInMonths();
                    } elseif ($transaction->recur_interval_type == 'years') {
                        $diff_from_today = $last_generated->diffInYears();
                    }
                    
                    //if last generated is today or less than today then continue
                    if ($diff_from_today == 0) {
                        continue;
                    }
                    //If difference from today is not multiple of today then continue
                    if ($transaction->recur_repetitions % $diff_from_today != 0) {
                        continue;
                    }
                }

                //Check if sell line quantity available; If not save as draft
                $save_as_draft = false;
                $out_of_stock_product = null;
                foreach ($transaction->sell_lines as $sell_line) {
                    if ($sell_line->product->enable_stock == 1) {
                        $current_stock = $this->productUtil->getCurrentStock($sell_line->variation_id, $transaction->location_id);

                        if ($current_stock < $sell_line->quantity) {
                            $out_of_stock_product = $sell_line->product->name . ' (' . $sell_line->product->sku . ')';
                            $save_as_draft = true;
                            break;
                        }
                    }
                }

                //Create new recurring invoice
                $recurring_invoice = $this->transactionUtil->createRecurringInvoice($transaction, $save_as_draft);

                //Update variation location details if status is final
                if ($recurring_invoice->status == 'final') {
                    foreach ($transaction->sell_lines as $sell_line) {
                        $this->productUtil->decreaseProductQuantity(
                            $sell_line->product_id,
                            $sell_line->variation_id,
                            $transaction->location_id,
                            $sell_line->quantity
                            );
                    }

                    $business = ['id' => $transaction->business_id,
                                    'accounting_method' => $transaction->business->accounting_method,
                                    'location_id' => $transaction->location_id
                                ];

                    $this->transactionUtil->mapPurchaseSell($business, $recurring_invoice->sell_lines, 'purchase');

                    $contact = Contact::find($recurring_invoice->contact_id);

                    //Auto send notification
                    $this->notificationUtil->autoSendNotification($transaction->business_id, 'new_sale', $recurring_invoice, $contact);
                }

                $recurring_invoice->out_of_stock_product = $out_of_stock_product;
                $recurring_invoice->subscription_no = $transaction->subscription_no;

                //Save database notification
                $created_by = User::find($transaction->created_by);
                $this->notificationUtil->recurringInvoiceNotification($created_by, $recurring_invoice);

                //if admin is different
                if ($created_by->id != $transaction->business->owner_id) {
                    $admin = User::find($transaction->business->owner_id);
                    $this->notificationUtil->recurringInvoiceNotification($admin, $recurring_invoice);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            die($e->getMessage());
        }
    }
}
