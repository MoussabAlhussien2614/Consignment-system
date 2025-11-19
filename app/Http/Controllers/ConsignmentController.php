<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsignmentRequest;
use App\Http\Requests\UpdateConsignmentRequest;
use App\Models\Consignment;
use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
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
        $vehicles = Vehicle::with('vendor')->orderBy('plate_number')->get(['id', 'plate_number', 'vendor_id']);
        $categories = \App\Models\Category::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Consignments/Create', [
            'vendors' => $vendors,
            'vehicles' => $vehicles,
            'categories' => $categories,
        ]);
    }

    public function store(StoreConsignmentRequest $request)
    {
        $validated = $request->validated();
        $items = $validated['items'];
        unset($validated['items']);

        $consignment = Consignment::create($validated);

        foreach ($items as $item) {
            $consignment->items()->create($item);
        }

        return redirect()->route('consignments.index')
            ->with('success', 'Consignment created successfully.');
    }

    public function show(Consignment $consignment)
    {
        $consignment->load(['vendor', 'vehicle', 'items.category']);

        // Get all vehicles for this consignment's vendor
        $vehicles = Vehicle::where('vendor_id', $consignment->vendor_id)
            ->with('vendor')
            ->orderBy('plate_number')
            ->get();

        // Get all vendors (for the data table)
        $vendors = Vendor::orderBy('name')->get();

        return Inertia::render('Consignments/Show', [
            'consignment' => $consignment,
            'vehicles' => $vehicles,
            'vendors' => $vendors,
        ]);
    }

    public function edit(Consignment $consignment)
    {
        $consignment->load(['items.category']);
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        $vehicles = Vehicle::orderBy('plate_number')->get(['id', 'plate_number', 'vendor_id']);
        $categories = \App\Models\Category::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Consignments/Edit', [
            'consignment' => $consignment,
            'vendors' => $vendors,
            'vehicles' => $vehicles,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateConsignmentRequest $request, Consignment $consignment)
    {
        $validated = $request->validated();
        $items = $validated['items'];
        unset($validated['items']);

        $consignment->update($validated);

        $consignment->items()->forceDelete();
        foreach ($items as $item) {
            $consignment->items()->create($item);
        }

        return redirect()->route('consignments.index')
            ->with('success', 'Consignment updated successfully.');
    }

    public function destroy(Consignment $consignment)
    {
        $consignment->delete();

        return redirect()->route('consignments.index')
            ->with('success', 'Consignment deleted successfully.');
    }

    public function receipt(Consignment $consignment)
    {
     
        $consignment->load(['vendor', 'vehicle', 'items.category']);

        $items = $consignment->items;

        $summary = [
            'total_quantity' => $items->sum('quantity'),
            'total_value' => $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity),
            'total_extra_expenses' => $items->sum(fn ($item) => (float) ($item->extra_expences ?? 0)),
            'total_commission' => $items->sum(fn ($item) => ((float) ($item->commission_rate ?? 0) / 100) * (float) $item->unit_price * $item->quantity),
        ];

        $pdf = Dompdf::loadView('pdfs.receipt', [
            'consignment' => $consignment,
            'summary' => $summary,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("receipt-{$consignment->id}.pdf");
    
    }
}
