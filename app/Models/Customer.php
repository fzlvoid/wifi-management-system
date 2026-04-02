<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ScopedBy([UserScope::class])]
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'name',
        'email',
        'phone',
        'address',
        'billing_cycle_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'billing_cycle_date' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class)->withoutGlobalScope(UserScope::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Computed status berdasarkan payment terbaru.
     * Returns: PAID | UNPAID | OVERDUE
     */
    public function getStatusAttribute(): string
    {
        $payment = $this->latestPayment;

        if (! $payment) {
            return 'UNPAID';
        }

        if ($payment->status === 'PAID') {
            return 'PAID';
        }

        // UNPAID — cek apakah sudah overdue
        if ($payment->due_date < now()->startOfDay()) {
            return 'OVERDUE';
        }

        return 'UNPAID';
    }
}
