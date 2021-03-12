<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

use App\TransactionPayment;

class TransactionPaymentUpdated
{
    use SerializesModels;

    public $transactionPayment;

    public $transactionType;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TransactionPayment $transactionPayment, $transactionType)
    {
        $this->transactionPayment = $transactionPayment;
        $this->transactionType = $transactionType;
    }
}
