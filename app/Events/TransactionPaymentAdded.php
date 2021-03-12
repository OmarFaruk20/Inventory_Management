<?php

namespace App\Events;

use App\TransactionPayment;
use Illuminate\Queue\SerializesModels;

class TransactionPaymentAdded
{
    use SerializesModels;

    public $transactionPayment;
    public $formInput;

    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @param  array $formInput = []
     * @return void
     */
    public function __construct(TransactionPayment $transactionPayment, $formInput = [])
    {
        $this->transactionPayment = $transactionPayment;
        $this->formInput = $formInput;
    }
}
