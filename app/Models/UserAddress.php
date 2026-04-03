<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'alamat',
        'province_code',
        'regency_code',
        'district_code',
        'village_code',
        'propinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'kodepos',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
