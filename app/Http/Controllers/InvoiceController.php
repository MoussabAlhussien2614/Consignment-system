<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }
    public function index(Request $request){
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        dump($request->vendor_id);
        if($request->vendor_id != null){
            $vendor = Vendor::find($request->vendor_id);
            $invoices = $this->invoiceService->generateInvoices($vendor,$request->from_date,$request->to_date);
            dd($invoices);
        }

        return Inertia::render("Invoices/Main",[
            "vendors" => $vendors,
            "data" => [
                [
                    "vendor_name" => "vendor_name_01",
                    "vehicle" => "vehicle_01",
                    "total_payable" => "200.00",
                    "commission_deduction" => "100.00",
                    "extra_expenses" => "20.00",
                ],
                [
                    "vendor_name" => "vendor_name_01",
                    "vehicle" => "vehicle_01",
                    "total_payable" => "200.00",
                    "commission_deduction" => "100.00",
                    "extra_expenses" => "20.00",
                ],
                [
                    "vendor_name" => "vendor_name_01",
                    "vehicle" => "vehicle_01",
                    "total_payable" => "200.00",
                    "commission_deduction" => "100.00",
                    "extra_expenses" => "20.00",
                ],
                [
                    "vendor_name" => "vendor_name_01",
                    "vehicle" => "vehicle_01",
                    "total_payable" => "200.00",
                    "commission_deduction" => "100.00",
                    "extra_expenses" => "20.00",
                ],
            ]
        ]);
    }

}
