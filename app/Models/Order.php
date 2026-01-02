<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const ADMIN_FEE = 10000; // Rp 10.000 per transaksi
    public const SHIPPING_COST = 5000; // Rp 5.000 ongkos kirim

    protected $fillable = [
        'user_id',
        'kurir_id',
        'total',
        'shipping_cost',
        'admin_fee',
        'status',
        'payment_method',
        'shipping_address',
        'phone',
        'notes',
        'paid_at',
        'picked_up_at',
        'delivered_at',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'paid_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kurir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Status helpers
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'paid' => 'info',
            'processing' => 'primary',
            'ready_pickup' => 'secondary',
            'shipped' => 'info',
            'delivered' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Diproses',
            'ready_pickup' => 'Siap Diambil Kurir',
            'shipped' => 'Dalam Pengiriman',
            'delivered' => 'Menunggu Konfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }
}
