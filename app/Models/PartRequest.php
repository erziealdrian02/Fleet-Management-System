<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'vehicle_id',
        'tanggal',
    ];

    public function detailRequest()
    {
        return $this->hasMany(PartRequestDetail::class, 'id_request');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
