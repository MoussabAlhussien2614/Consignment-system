<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;

class InvoiceController extends Controller
{
    public function index(){
        $obj = new stdClass();
        $obj->vendor_name = "vendor_name";
        $obj->vehicle = "vehicle";
        $obj->total_payable = "200.00";
        $obj->commission_deduction = "100.00";
        $obj->extra_expenses   = "20.00";

        return Inertia::render("Invoices/Main",[
            "data" => [
                $obj,
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
