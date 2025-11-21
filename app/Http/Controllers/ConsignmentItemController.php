<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateConsignmentItemRequest;
use App\Models\Category;
use App\Models\ConsignmentItem;
use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ConsignmentItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ConsignmentItem::query()
            ->with(['consignment.vendor', 'consignment.vehicle', 'category']);

        if ($request->filled('vendor_id')) {
            $query->whereHas('consignment', function ($q) use ($request) {
                $q->where('vendor_id', $request->vendor_id);
            });
        }

        if ($request->filled('vehicle_id')) {
            $query->whereHas('consignment', function ($q) use ($request) {
                $q->where('vehicle_id', $request->vehicle_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('available_only')) {
            $query->where('quantity_available', '>', 0);
        }

        $items = $query->orderBy('id', 'desc')->paginate(10);

        return inertia('ConsignmentItems/Index', [
            'items' => $items,
            'filters' => $request->all(),
        ]);
    }


    
    /**
     * Display the specified resource.
     */
    public function show(ConsignmentItem $consignmentItem)
    {
        
        return inertia('ConsignmentItems/Show', [
            'consignment_item' => $consignmentItem->load("category"),
        ]);
    }

    
    /**
     * Display the specified resource.
     */
    public function edit(ConsignmentItem $consignmentItem)
    {
        
        return inertia('ConsignmentItems/Edit', [
            'consignment_item' => $consignmentItem->load("category"),
            'categories' => Category::get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsignmentItemRequest $request, ConsignmentItem $consignmentItem)
    {
        $consignmentItem->update($request->validated());
        
        return redirect()->route('consignment-items.index')
            ->with('success', 'Item updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsignmentItem $consignmentItem)
    {
        $consignmentItem->delete();
        return redirect()->route('consignment-items.index')
            ->with('success', 'Item deleted successfully.');
    }
}
