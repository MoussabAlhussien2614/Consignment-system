<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsignmentController extends Controller
{
    public function index(){
        return Inertia::render("Consignment/Consignment",[]);
    }
}
