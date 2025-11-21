<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id'    => Vendor::factory(),
            'plate_number' => strtoupper($this->faker->bothify('???-####')),
            'reference_name' => fake()->randomElement(["red","green","black"]) . " ". fake()->randomElement(["toyota","mitsubishi","hyundai"]),
            'driver_name'  => $this->faker->name(),
            'driver_phone' => $this->faker->phoneNumber(),
            'vehicle_type' => $this->faker->randomElement(['car','truck','van','other']),
            'notes'        => $this->faker->sentence(),
        ];
    }
}
