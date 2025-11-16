<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'contact_name',
        'contact_phone',
        'email',
        'address',
        'notes',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function consignments()
    {
        return $this->hasMany(Consignment::class);
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Vehicle::class);
    }
}
