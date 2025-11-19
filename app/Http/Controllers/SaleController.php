<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\ConsignmentItem;
use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

        return Inertia::render('Sales/Create', [
            'items' => $items,
        ]);
    }

    

    public function store(StoreSaleRequest $request)
    {
        Sale::create($request->validated() + [
            "extra_expenses" => 0
        ]);

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

        return Inertia::render('Sales/Edit', [
            'sale' => $sale,
            'items' => $items,
        ]);
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $sale->update($request->validated());

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
