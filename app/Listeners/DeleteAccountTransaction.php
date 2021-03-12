<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\AccountTransaction;

use App\Utils\ModuleUtil;

class DeleteAccountTransaction
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
    public function handle($event)
    {
        if(!$this->moduleUtil->isModuleEnabled('account')){
            return true;
        }

        AccountTransaction::where('account_id', $event->accountId)
                        ->where('transaction_payment_id', $event->transactionPaymentId)
                        ->delete();
    }
}
