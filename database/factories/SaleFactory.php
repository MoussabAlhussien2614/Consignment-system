<?php

namespace Database\Factories;

use App\Models\ConsignmentItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id'  => ConsignmentItem::factory(),
            'quantity' => rand(1, 5),
            'price'    => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}
