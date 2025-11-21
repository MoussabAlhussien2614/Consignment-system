<?php

namespace App\Http\Controllers;

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
            'vendors' => Vendor::select('id', 'name')->get(),
            'vehicles' => Vehicle::select('id', 'plate_no')->get(),
            'filters' => $request->all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
