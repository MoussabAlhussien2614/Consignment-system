<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsignmentItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'consignment_id',
        'product_id',
        'quantity',
        'available_quantity',
        'unit_price',
        'notes'
    ];

    public function consignment(){
        return $this->belongsTo(Consignment::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
