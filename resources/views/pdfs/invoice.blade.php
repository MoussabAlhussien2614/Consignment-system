<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Bill</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1f2937;
            line-height: 1.5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 32px;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 16px;
        }
        .header h1 {
            font-size: 28px;
            color: #4f46e5;
            margin-bottom: 6px;
        }
        .header p {
            color: #6b7280;
        }

        .side-text {
            font-size: 16;
            font: bold;
            color: #050415ff;
            margin-bottom: 6px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        .info-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
        }
        .info-card h3 {
            font-size: 14px;
            color: #4f46e5;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .info-card p {
            font-size: 13px;
            margin-bottom: 6px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12px;
        }
        .items-table thead {
            background-color: #f3f4f6;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
        }
        .summary {
            margin-top: 30px;
            border-top: 2px solid #e5e7eb;
            padding-top: 16px;
        }
        .summary-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .summary-row strong {
            width: 220px;
            text-align: right;
            margin-right: 16px;
        }
        .summary-row span {
            width: 150px;
            text-align: right;
            font-weight: 700;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
            border-top: 1px solid #e5e7eb;
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Vendor Invoice</h1>
            <p>Invoice generated from consignments sales</p>
        </div>

        <div class="side-text">
            <p>Invoice Items</p>
        </div>


        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Extra_Expenses</th>
                    <th>Commission</th>
                    <th>Total_Sale</th>
                    <th>Sold_At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                  
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->extra_expenses}}</td>
                        <td>{{$item->commission}}</td>
                        <td>{{$item->price * $item->quantity}}</td>
                        <td>{{$item->time_sold}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        
        <div class="side-text">
            <p>Invoice Footer</p>
        </div>


        <table class="items-table">
            <thead>
                <tr>
                    <th>Vendor_Name</th>
                    <th>Vehicle</th>
                    <th>Total_Sales</th>
                    <th>Commission_Deduction</th>
                    <th>Extra_Expenses</th>
                    <th>Total_Payable</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>{{$invoice->vehicle->vendor->name}}</td>
                        <td>{{$invoice->vehicle->plate_number}}</td>
                        <td>{{$invoice->total_sales}}</td>
                        <td>{{$invoice->commission_deduction}}</td>
                        <td>{{$invoice->expenses_deduction}}</td>
                        <td>{{$invoice->net_amount_payable}}</td>
                    </tr>
            </tbody>
        </table>

    </div>
</body>
</html>

