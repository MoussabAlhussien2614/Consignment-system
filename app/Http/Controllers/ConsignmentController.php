<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsignmentRequest;
use App\Http\Requests\UpdateConsignmentRequest;
use App\Models\Consignment;
use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Consignment::query()->with(['vendor', 'vehicle']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicle', function ($vehicleQuery) use ($search) {
                        $vehicleQuery->where('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        $consignments = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Consignments/Index', [
            'consignments' => $consignments,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        $vehicles = Vehicle::orderBy('plate_number')->get(['id', 'plate_number', 'vendor_id']);

        return Inertia::render('Consignments/Create', [
            'vendors' => $vendors,
            'vehicles' => $vehicles,
        ]);
    }

    public function store(StoreConsignmentRequest $request)
    {
        Consignment::create($request->validated());

        return redirect()->route('consignments.index')
            ->with('success', 'Consignment created successfully.');
    }

    public function show(Consignment $consignment)
    {
        $consignment->load(['vendor', 'vehicle', 'items.product']);

        return Inertia::render('Consignments/Show', [
            'consignment' => $consignment,
        ]);
    }

    public function edit(Consignment $consignment)
    {
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        $vehicles = Vehicle::orderBy('plate_number')->get(['id', 'plate_number', 'vendor_id']);

        return Inertia::render('Consignments/Edit', [
            'consignment' => $consignment,
            'vendors' => $vendors,
            'vehicles' => $vehicles,
        ]);
    }

    public function update(UpdateConsignmentRequest $request, Consignment $consignment)
    {
        $consignment->update($request->validated());

        return redirect()->route('consignments.index')
            ->with('success', 'Consignment updated successfully.');
    }

    public function destroy(Consignment $consignment)
    {
        $consignment->delete();

        return redirect()->route('consignments.index')
            ->with('success', 'Consignment deleted successfully.');
    }
}
