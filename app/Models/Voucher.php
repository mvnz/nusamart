<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'name', 'description',
        'discount_type', 'discount_value', 'max_discount', 'min_purchase',
        'quota', 'used_count',
        'start_date', 'end_date', 'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'start_date'     => 'datetime',
        'end_date'       => 'datetime',
        'discount_value' => 'float',
        'max_discount'   => 'float',
        'min_purchase'   => 'float',
    ];

    // ── Scopes ──────────────────────────────────────────────────

    public function scopeActive($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where(fn($q) => $q->whereNull('start_date')->orWhere('start_date', '<=', $now))
            ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $now));
    }

    // ── Status helpers ───────────────────────────────────────────

    public function isActive(): bool
    {
        if (! $this->is_active) return false;
        $now = now();
        if ($this->start_date && $this->start_date->gt($now)) return false;
        if ($this->end_date   && $this->end_date->lt($now))   return false;
        if ($this->quota > 0  && $this->used_count >= $this->quota) return false;
        return true;
    }

    public function isExpired(): bool
    {
        return $this->end_date && $this->end_date->lt(now());
    }

    public function isQuotaFull(): bool
    {
        return $this->quota > 0 && $this->used_count >= $this->quota;
    }

    public function isScheduled(): bool
    {
        return $this->start_date && $this->start_date->gt(now());
    }

    public function getStatusAttribute(): string
    {
        if (! $this->is_active) return 'inactive';
        if ($this->isExpired())  return 'expired';
        if ($this->isScheduled()) return 'scheduled';
        if ($this->quota > 0 && $this->used_count >= $this->quota) return 'quota_full';
        return 'active';
    }

    // ── Discount calculation ─────────────────────────────────────

    public function calculateDiscount(float $orderTotal): float
    {
        if ($orderTotal < $this->min_purchase) return 0;

        if ($this->discount_type === 'percentage') {
            $disc = $orderTotal * ($this->discount_value / 100);
            if ($this->max_discount) $disc = min($disc, $this->max_discount);
            return $disc;
        }

        return min($this->discount_value, $orderTotal);
    }

    // ── Formatted helpers ─────────────────────────────────────────

    public function getDiscountLabelAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            $label = $this->discount_value . '%';
            if ($this->max_discount) $label .= ' (maks Rp ' . number_format($this->max_discount, 0, ',', '.') . ')';
            return $label;
        }
        return 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }
}
