<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consignment>
 */
class ConsignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id'     => Vendor::factory(),
            'vehicle_id'    => Vehicle::factory(),
            'reference_no'  => strtoupper($this->faker->unique()->bothify('REF-#####')),
            'delivered_at'  => now()->subDays(rand(1, 30)),
            'status'        => $this->faker->randomElement(['pending','in_progress','closed']),
            'notes'         => $this->faker->sentence(),
        ];
    }
}
