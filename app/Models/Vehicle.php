<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'plate_number',
        'driver_name',
        'driver_phone',
        'vehicle_type',
        'notes'
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function consignments(){
        return $this->hasMany(Consignment::class);
    }

}
