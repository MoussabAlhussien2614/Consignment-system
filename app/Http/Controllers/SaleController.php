<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\ConsignmentItem;
use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
   
        $query = Sale::query()->with(['item.consignment.vendor', 'item.consignment.vehicle', 'item.category']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', function ($itemQuery) use ($search) {
                    $itemQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                })
                    ->orWhereHas('item.consignment', function ($consignmentQuery) use ($search) {
                        $consignmentQuery->where('reference_no', 'like', "%{$search}%");
                    });
            });
        }

        $sales = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Sales/Index', [
            'sales' => $sales,
            'filters' => $request->only(['search']),
        ]);
    }

    
    public function create()
    {
        $items = ConsignmentItem::with(['consignment.vendor', 'consignment.vehicle', 'category'])
            ->orderBy('name')
            ->get();

        $vendors = Vendor::orderBy('name')->get();
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return Inertia::render('Sales/Create', [
            'items' => $items,
            'vendors' => $vendors,
            'vehicles' => $vehicles,
        ]);
    }

    

    public function store(StoreSaleRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $item = ConsignmentItem::lockForUpdate()->findOrFail($data['item_id']);

            // double-check availability
            if (($item->quantity_available ?? 0) < $data['quantity']) {
                throw new \Exception('Insufficient available quantity for this item.');
            }

            $sale = Sale::create($data + [
                'extra_expenses' => $data['extra_expenses'] ?? 0,
            ]);

            $item->quantity_available = ($item->quantity_available ?? 0) - $data['quantity'];
            if ($item->quantity_available < 0) $item->quantity_available = 0;
            $item->save();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['item.consignment.vendor', 'item.consignment.vehicle', 'item.category']);

        return Inertia::render('Sales/Show', [
            'sale' => $sale,
        ]);
    }

    public function edit(Sale $sale)
    {
        $sale->load(['item.consignment.vendor', 'item.consignment.vehicle', 'item.category']);
        $items = ConsignmentItem::with(['consignment.vendor', 'consignment.vehicle', 'category'])
            ->orderBy('name')
            ->get();

        $vendors =Vendor::orderBy('name')->get();
        $vehicles = Vehicle::orderBy('plate_number')->get();

        return Inertia::render('Sales/Edit', [
            'sale' => $sale,
            'items' => $items,
            'vendors' => $vendors,
            'vehicles' => $vehicles,
        ]);
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $data = $request->validated();

        DB::transaction(function () use ($sale, $data) {
            $oldItem = $sale->item()->lockForUpdate()->first();
            $newItem = ConsignmentItem::lockForUpdate()->findOrFail($data['item_id']);

            $oldQty = $sale->quantity;
            $newQty = $data['quantity'];

            if ($oldItem && $oldItem->id !== $newItem->id) {

                $oldItem->quantity_available = ($oldItem->quantity_available ?? 0) + $oldQty;
                $oldItem->save();

                if (($newItem->quantity_available ?? 0) < $newQty) {
                    throw new \Exception('Insufficient available quantity for selected item.');
                }
                $newItem->quantity_available = ($newItem->quantity_available ?? 0) - $newQty;
                $newItem->save();
            } else {

                $diff = $newQty - $oldQty;
                if ($diff > 0) {
                    if (($newItem->quantity_available ?? 0) < $diff) {
                        throw new \Exception('Insufficient available quantity for this item.');
                    }
                    $newItem->quantity_available = ($newItem->quantity_available ?? 0) - $diff;
                } else if ($diff < 0) {
                    $newItem->quantity_available = ($newItem->quantity_available ?? 0) + abs($diff);
                }
                $newItem->save();
            }

            $sale->update($data);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
