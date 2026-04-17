<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([UserScope::class])]
class CustomerSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'package_id',
        'start_date',
        'end_date',
        'billing_cycle_date',
        'is_active',
    ];

    protected $appends = [
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'billing_cycle_date' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Dapatkan status dari subscription berdasar end_date (dinamis).
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if (empty($attributes['is_active'])) {
                    return 'inactive';
                }
                if (empty($attributes['end_date'])) {
                    return 'active';
                }

                $endDate = Carbon::parse($attributes['end_date'])->startOfDay();
                $now = now()->startOfDay();

                if ($now->gt($endDate)) {
                    return 'overdue';
                } elseif ($now->copy()->addDays(7)->gte($endDate)) {
                    return 'due_soon';
                }

                return 'active';
            }
        );
    }

    /**
     * Relasi ke entitas User (Pemilik RT/RW Net).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke entitas Customer (Pelanggan yang berlangganan).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ke entitas Package (Paket internet yang dipilih).
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Relasi ke entitas Billing (Daftar tagihan dari langganan ini).
     * Secara eksplisit mendefinisikan foreign key 'subscription_id'
     * karena nama tabel dan modelnya menggunakan kata 'Subscription'.
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class, 'subscription_id');
    }
}
