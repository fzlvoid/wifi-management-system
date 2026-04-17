<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([UserScope::class])]
class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'subscription_id',
        'amount',
        'status',
        'due_date',
        'payment_date',
        'billing_month',
        'billing_year',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'due_date' => 'date',
            'payment_date' => 'datetime',
            'billing_month' => 'integer',
            'billing_year' => 'integer',
        ];
    }

    /**
     * Relasi ke entitas User (Pemilik RT/RW Net).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke entitas Customer (Pelanggan yang ditagih).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ke entitas CustomerSubscription (Data langganan yang menghasilkan tagihan ini).
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'subscription_id');
    }
}
