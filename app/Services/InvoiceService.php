<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Vendor;

use function Symfony\Component\Clock\now;

class InvoiceService{

    public function generateInvoices(Vendor $vendor, $from_date, $to_date){
        $vehicles = $vendor->vehicles()->get();
        $invoice_ids = [];
        foreach($vehicles as $vehicle){
            $invoice_ids[] = $this->generateInvoicesPerVehicle($vehicle,$from_date,$to_date);
        }
        return $invoice_ids;
    }


    public function generateInvoicesPerVehicle(Vehicle $vehicle, $from_date, $to_date){
        $invoice = Invoice::create([
                "net_amount_payable" => 0,
                "commission_deduction" => 0,
                "expenses_deduction" => 0,
                "total_sales" => 0,
                "vehicle_id" => $vehicle->id,
        ]);
        $invoice_ids[] = $invoice->id;
        $sales = Sale::ofVehicle($vehicle)
            // ->whereBetween("created_at", [$from_date,$to_date])
            ->with("item")
            ->get();

        foreach ($sales as $sale){
            $this->generateInvoiceItemFromSale($sale,$invoice);
        }
        $invoice->save();
        return $invoice->id;
    }

    public function generateInvoiceItemFromSale(Sale $sale, Invoice $invoice){
        $invoice_item = InvoiceItem::create([
                "product_name" => $sale->item->name,
                "price" => $sale->price,
                "quantity" => $sale->quantity,
                "commission" => $sale->item->commission_rate,
                "extra_expenses" => $sale->extra_expenses,
                "invoice_id" => $invoice->id,
                "time_sold" => now(),
            ]);
            $invoice->total_sales += ($total_sale  = $invoice_item->price * $invoice_item->quantity);
            $invoice->expenses_deduction += ($total_expenses = $invoice_item->extra_expenses * $invoice_item->quantity);
            $invoice->commission_deduction += ($commissioned = ($total_sale - $total_expenses) * ($invoice_item->commission/100));
            $invoice->net_amount_payable += ($total_sale - $total_expenses) - $commissioned;

            return $invoice_item;
    }

}