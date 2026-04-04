<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'city', 'device_type', 'visit_date'];

    protected $casts = [
        'visit_date' => 'date',
    ];
}
