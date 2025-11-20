<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'net_amount_payable',
        'commission_deduction',
        'expenses_deduction',
        'total_sales',
    ];

    protected function casts(): array
    {
        return [
            'net_amount_payable' => 'decimal:2',
            'commission_deduction' => 'decimal:2',
            'expenses_deduction' => 'decimal:2',
            'total_sales' => 'decimal:2',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class,"invoice_id");
    }

}
