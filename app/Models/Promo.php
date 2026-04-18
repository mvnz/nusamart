<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'original_price',
        'promo_price',
        'discount_percentage',
        'start_date',
        'end_date',
        'quota',
        'used_quota',
        'is_active',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'promo_price' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke User (penjual)
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check apakah promo masih aktif (tidak expired)
     */
    public function isActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        
        // Cek apakah sudah masuk periode promo
        if ($now < $this->start_date || $now > $this->end_date) {
            return false;
        }

        // Cek apakah kuota masih tersedia
        if ($this->quota > 0 && $this->used_quota >= $this->quota) {
            return false;
        }

        return true;
    }

    /**
     * Cek apakah promo belum mulai
     */
    public function isScheduled(): bool
    {
        return $this->is_active && Carbon::now() < $this->start_date;
    }

    /**
     * Cek apakah promo sudah berakhir
     */
    public function isExpired(): bool
    {
        return Carbon::now() > $this->end_date;
    }

    /**
     * Cek apakah kuota habis
     */
    public function isQuotaFull(): bool
    {
        return $this->quota > 0 && $this->used_quota >= $this->quota;
    }

    /**
     * Hitung diskon persen
     */
    public function getDiscountPercentage(): int
    {
        return round((($this->original_price - $this->promo_price) / $this->original_price) * 100);
    }

    /**
     * Increment used quota
     */
    public function incrementUsedQuota()
    {
        if ($this->quota == 0) return; // unlimited
        
        $this->increment('used_quota');
    }

    /**
     * Decrement used quota (jika order dibatalkan)
     */
    public function decrementUsedQuota()
    {
        if ($this->quota == 0) return; // unlimited
        
        if ($this->used_quota > 0) {
            $this->decrement('used_quota');
        }
    }

    /**
     * Deactivate promo
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Activate promo
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Get sisa kuota
     */
    public function getRemainingQuota(): int
    {
        if ($this->quota == 0) return -1; // unlimited
        return max(0, $this->quota - $this->used_quota);
    }

    /**
     * Scope: ambil promo yang sedang aktif
     */
    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now());
    }

    /**
     * Scope: ambil promo berdasarkan product
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}
