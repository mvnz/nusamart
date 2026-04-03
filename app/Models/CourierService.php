<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierService extends Model
{
    protected $fillable = ['courier_id', 'name', 'code', 'estimated_days', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
