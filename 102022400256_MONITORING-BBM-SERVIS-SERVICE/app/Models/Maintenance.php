<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'vehicle_id',
        'fuel_limit',
        'last_service_date',
        'operational_coupon',
        'notes',
    ];
}