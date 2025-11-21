<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Consignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConsignmentItem>
 */
class ConsignmentItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = rand(1, 50);

        return [
            'consignment_id'     => Consignment::factory(),
            'name'               => $this->faker->words(2, true),
            'sku'                => $this->faker->unique()->bothify('SKU-#####'),
            'category_id'        => Category::factory(),
            'quantity'           => $qty,
            'unit_price'         => $this->faker->randomFloat(2, 5, 200),
            'extra_expences'     => $this->faker->randomFloat(2, 0, 50),
            'commission_rate'    => rand(1, 20),
            'notes'              => $this->faker->sentence(),
            'quantity_available' => $qty, 
        ];
    }
}
