<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->company(),
            'code'          => $this->faker->unique()->bothify('VND-###'),
            'contact_name'  => $this->faker->name(),
            'contact_phone' => $this->faker->phoneNumber(),
            'email'         => $this->faker->safeEmail(),
            'address'       => $this->faker->address(),
            'notes'         => $this->faker->sentence(),
        ];
    }
}
