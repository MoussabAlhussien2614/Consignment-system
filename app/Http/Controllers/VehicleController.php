<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query()->with(['vendor'])->withCount(['consignments']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                    ->orWhere('driver_name', 'like', "%{$search}%")
                    ->orWhere('driver_phone', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $vehicles = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Vehicles/Index', [
            'vehicles' => $vehicles,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Vehicles/Create', [
            'vendors' => $vendors,
        ]);
    }

    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());
        $vehicle->load('vendor');

      

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    public function storeQuick(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());
        $vehicle->load('vendor');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($vehicle, 201);
        }

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['vendor', 'consignments']);

        return Inertia::render('Vehicles/Show', [
            'vehicle' => $vehicle,
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Vehicles/Edit', [
            'vehicle' => $vehicle,
            'vendors' => $vendors,
        ]);
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }
}
