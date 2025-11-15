<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'vehicle_id',
        'reference_no',
        'delivered_at',
        'status',
        'notes'
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function items(){
        return $this->hasMany(ConsignmentItem::class);
    }


}
