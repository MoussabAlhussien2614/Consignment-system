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
        'name',
        'sku',
        'category_id',
        'quantity',
        'unit_price',
        'extra_expences',
        'commission_rate',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'extra_expences' => 'decimal:2',
        ];
    }

    public function consignment()
    {
        return $this->belongsTo(Consignment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
