<?php

namespace Database\Seeders;

use App\Models\ConsignmentItem;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ConsignmentItem::all();

        if ($items->isEmpty()) {
            return;
        }

        $items->each(function (ConsignmentItem $item) {
            Sale::factory()
                ->count(rand(0, 3))
                ->state([
                    'item_id' => $item->id,
                ])
                ->create();
        });
    }
}
