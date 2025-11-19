<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Consignment;
use App\Models\ConsignmentItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsignmentItemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $consignments = Consignment::all();

        if ($categories->isEmpty() || $consignments->isEmpty()) {
            return;
        }

        $consignments->each(function (Consignment $consignment) use ($categories) {
            ConsignmentItem::factory()
                ->count(rand(3, 7))
                ->state(function () use ($consignment, $categories) {
                    $category = $categories->random();

                    return [
                        'consignment_id' => $consignment->id,
                        'category_id' => $category->id,
                    ];
                })
                ->create();
        });
    }
}

