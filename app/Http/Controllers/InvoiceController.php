<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Vendor;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(Request $request){
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        $invoices = [];
        if($request->vendor_id != null){
            $vendor = Vendor::find($request->vendor_id);
            $invoices = $this->invoiceService->generateInvoices($vendor,$request->from_date,$request->to_date);
            $invoices = Invoice::with("vehicle.vendor")->findMany($invoices);
        }

        return Inertia::render("Invoices/Main",[
            "vendors" => $vendors,
            "data" => $invoices,
        ]);
    }

    public function show(Request $request, Invoice $invoice){
        return Inertia::render("Invoices/InvoiceDetails",[
            "invoice" => $invoice->load("vehicle.vendor"),
            "items" => $invoice->items()->get(),
          ]);
          
    }

     public function invoice(Invoice $invoice)
    {
     
        $invoice->load('vehicle.vendor');

        $items = $invoice->items;

        $summary = [
            'total_quantity' => $items->sum('quantity'),
            'total_value' => $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity),
            'total_extra_expenses' => $items->sum(fn ($item) => (float) ($item->extra_expences ?? 0)),
            'total_commission' => $items->sum(fn ($item) => ((float) ($item->commission_rate ?? 0) / 100) * (float) $item->unit_price * $item->quantity),
        ];

        $pdf = Dompdf::loadView('pdfs.invoice', [
            'invoice' => $invoice,
            'items' => $items,
            'summary' => $summary,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("invoice-{$invoice->id}.pdf");
    
    }

}
