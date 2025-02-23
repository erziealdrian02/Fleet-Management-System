<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate',
        'type',
        'status',
        'fuel_capacity',
        'last_service_date',
        'mileage',
        'gps_enabled',
    ];

    public function gps()  
    {  
        return $this->hasOne(GpsTracking::class, 'vehicle_id', 'id');  
    }
}
