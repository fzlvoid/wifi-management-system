<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'username', 'email', 'password', 'is_active', 'role', 'api_key', 'subscription_start', 'subscription_end', 'remember_token_expired_at'])]
#[Hidden(['password', 'remember_token', 'api_key'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'password' => 'hashed',
            'subscription_start' => 'date',
            'subscription_end' => 'date',
            'remember_token_expired_at' => 'datetime',
        ];
    }

    public function isSubscriptionActive(): bool
    {
        if ($this->role === 'admin') {
            return true;
        }

        return $this->subscription_end !== null
            && $this->subscription_end->gte(now()->startOfDay());
    }

    /**
     * Generate a unique API key for the user.
     */
    public static function generateApiKey(): string
    {
        return Str::random(64);
    }

    public function packages()
    {
        return $this->hasMany(Package::class)->withoutGlobalScope(UserScope::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class)->withoutGlobalScope(UserScope::class);
    }
}
