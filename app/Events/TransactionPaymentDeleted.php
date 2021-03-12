<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class TransactionPaymentDeleted
{
    use SerializesModels;

    public $transactionPaymentId;

    public $accountId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($transactionPaymentId, $accountId)
    {
        $this->transactionPaymentId = $transactionPaymentId;

        $this->accountId = $accountId;
    }
}
