<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoSlot extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Return only active slots, ordered by start_time.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('start_time');
    }

    /**
     * Human-readable time range, e.g. "10:00 – 12:00"
     */
    public function getTimeRangeAttribute(): string
    {
        return substr($this->start_time, 0, 5) . ' – ' . substr($this->end_time, 0, 5);
    }
}
