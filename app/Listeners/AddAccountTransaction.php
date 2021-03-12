<?php

namespace App\Listeners;

use App\Events\TransactionPaymentAdded;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\AccountTransaction;

use App\Utils\ModuleUtil;

class AddAccountTransaction
{
    protected $moduleUtil;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TransactionPaymentAdded $event)
    {
        if(!$this->moduleUtil->isModuleEnabled('account')){
            return true;
        }

        // //Create new account transaction
        if(!empty($event->formInput['account_id'])){
            $account_transaction_data = [
                'amount' => $event->formInput['amount'],
                'account_id' => $event->formInput['account_id'],
                'type' => AccountTransaction::getAccountTransactionType($event->formInput['transaction_type']),
                'operation_date' => $event->transactionPayment->paid_on,
                'created_by' => $event->transactionPayment->created_by,
                'transaction_id' => $event->transactionPayment->transaction_id,
                'transaction_payment_id' =>  $event->transactionPayment->id
            ];

            AccountTransaction::createAccountTransaction($account_transaction_data);
        }
    }
}
