<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartRequestDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_request',
        'id_parts',
        'quantity',
    ];

    public function request()
    {
        return $this->belongsTo(PartRequest::class, 'id_request');
    }

    public function parts()
    {
        return $this->belongsTo(SparePart::class, 'id_parts');
    }
}
