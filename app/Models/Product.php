<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'unit',
        'cost_price',
        'sale_price'
    ];

    public function consignmentItems(){
        return $this->hasMany(ConsignmentItem::class);
    }


    // Scopes
    public function scopeActive($query){
        return $query->where('deleted_at', null);
    }

    // Accessor
    public function getSalePriceFormattedAttribute(){
        return number_format($this->sale_price,2);
    }
}
