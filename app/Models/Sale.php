<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
        'price',
        'extra_expenses',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function scopeOfVehicle(Builder $query, Vehicle $vehicle){
        return $query->whereHas("item",function($query) use ($vehicle) {
                return $query->whereHas("consignment",function($query) use ($vehicle) {
                    return $query->whereHas("vehicle",function($query) use ($vehicle) {
                        return $query->where("id",$vehicle->id);
                    });
                });
            });
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ConsignmentItem::class, 'item_id');
    }
}
