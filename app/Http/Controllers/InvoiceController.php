<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Symfony\Component\CssSelector\Node\FunctionNode;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        $vendor = Vendor::find($request->vendor_id);
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
