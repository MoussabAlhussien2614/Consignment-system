<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::query()->withCount(['vehicles', 'consignments']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%");
            });
        }

        $vendors = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Vendors/Index', [
            'vendors' => $vendors,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Vendors/Create');
    }

    public function store(StoreVendorRequest $request)
    {
        $vendor = Vendor::create($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($vendor, 201);
        }

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['vehicles', 'consignments']);
        $invoices = $vendor->invoices()->with('vehicle')->latest()->get();

        return Inertia::render('Vendors/Show', [
            'vendor' => $vendor,
            'invoices' => $invoices,
        ]);
    }

    public function edit(Vendor $vendor)
    {
        return Inertia::render('Vendors/Edit', [
            'vendor' => $vendor,
        ]);
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->validated());

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }
}
