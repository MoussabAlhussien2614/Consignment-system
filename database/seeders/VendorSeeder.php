<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::factory()
            ->count(8)
            ->has(Vehicle::factory()->count(3), 'vehicles')
            ->create();
    }
}

