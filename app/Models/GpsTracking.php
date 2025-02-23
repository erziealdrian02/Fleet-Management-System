<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'latitude',
        'longitude',
        'speed',
        'timestamp',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
