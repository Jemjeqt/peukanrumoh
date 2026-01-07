<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'phone',
        'address',
        'store_name',
        'store_description',
        'store_logo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Append avatar field for API (Flutter compatibility)
    protected $appends = ['avatar'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    // Accessor for avatar (maps to store_logo)
    public function getAvatarAttribute(): ?string
    {
        return $this->store_logo;
    }

    // Role Checks
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPedagang(): bool
    {
        return $this->role === 'pedagang';
    }

    public function isKurir(): bool
    {
        return $this->role === 'kurir';
    }

    public function isPembeli(): bool
    {
        return $this->role === 'pembeli';
    }

    // Relationships
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Order::class, 'kurir_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
