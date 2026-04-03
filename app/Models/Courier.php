<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = ['name', 'code', 'logo', 'description', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function services()
    {
        return $this->hasMany(CourierService::class)->orderBy('name');
    }

    public function activeServices()
    {
        return $this->hasMany(CourierService::class)->where('is_active', true)->orderBy('name');
    }
}
