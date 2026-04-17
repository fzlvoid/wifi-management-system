<?php

namespace App\Events;

use App\Models\Billing;
use App\Models\Customer;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PaymentReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Billing $billing,
        public readonly Customer $customer,
        /** @var Collection<int, Billing> */
        public readonly mixed $remainingUnpaidBillings,
    ) {}
}
