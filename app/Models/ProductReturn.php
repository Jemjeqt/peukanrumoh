<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReturn extends Model
{
    protected $table = 'returns';
    
    protected $fillable = [
        'user_id',
        'order_id',
        'kurir_id',
        'replacement_kurir_id',
        'reason',
        'evidence',
        'type',
        'status',
        'admin_notes',
        'approved_at',
        'picked_up_at',
        'received_at',
        'replacement_shipped_at',
        'replacement_delivered_at',
        'refund_sent_at',
        'refund_proof',
        'completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'received_at' => 'datetime',
        'replacement_shipped_at' => 'datetime',
        'replacement_delivered_at' => 'datetime',
        'refund_sent_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function kurir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    public function replacementKurir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replacement_kurir_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'pickup' => 'Siap Diambil Kurir',
            'delivering' => 'Diantar ke Pedagang',
            'received' => 'Diterima Pedagang',
            // Replacement flow
            'replacement_shipping' => 'Barang Pengganti Dikirim',
            'replacement_delivered' => 'Menunggu Konfirmasi Pembeli',
            // Refund flow
            'refund_sent' => 'Uang Dikirim',
            'refund_confirmed' => 'Menunggu Konfirmasi Pembeli',
            'completed' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'pickup' => 'warning',
            'delivering' => 'info',
            'received' => 'info',
            'replacement_shipping' => 'info',
            'replacement_delivered' => 'warning',
            'refund_sent' => 'info',
            'refund_confirmed' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'replacement' ? 'Ganti Barang' : 'Pengembalian Uang';
    }

    public function getEvidenceUrlAttribute(): ?string
    {
        if (!$this->evidence) return null;
        if (str_starts_with($this->evidence, 'http')) return $this->evidence;
        return asset('storage/' . $this->evidence);
    }

    public function getRefundProofUrlAttribute(): ?string
    {
        if (!$this->refund_proof) return null;
        if (str_starts_with($this->refund_proof, 'http')) return $this->refund_proof;
        return asset('storage/' . $this->refund_proof);
    }
}

