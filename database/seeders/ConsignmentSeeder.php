<?php

namespace Database\Seeders;

use App\Models\Consignment;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsignmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::with('vendor')->get();

        if ($vehicles->isEmpty()) {
            return;
        }

        Consignment::factory()
            ->count(25)
            ->state(function () use ($vehicles) {
                $vehicle = $vehicles->random();

                return [
                    'vehicle_id' => $vehicle->id,
                    'vendor_id' => $vehicle->vendor_id,
                ];
            })
            ->create();
    }
}

