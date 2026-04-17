<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([UserScope::class])]
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
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
     * Relasi ke entitas CustomerSubscription (Data Langganan Paket).
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(CustomerSubscription::class);
    }

    /**
     * Relasi ke entitas Billing (Data Tagihan).
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }
}
