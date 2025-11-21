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

            $numSales = rand(0, 3);

            for ($i = 0; $i < $numSales; $i++) {

                if ($item->quantity_available <= 0) {
                    break;
                }

                $maxQty = min(5, $item->quantity_available);
                $saleQty = rand(1, $maxQty);

                Sale::factory()->create([
                    'item_id'  => $item->id,
                    'quantity' => $saleQty,
                ]);

                $item->quantity_available -= $saleQty;
                $item->save();
            }
        });
    }
}
