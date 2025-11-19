<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consignment Receipt #{{ $consignment->reference_no }}</title>
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
            <h1>Consignment Receipt</h1>
            <p>Receipt generated for delivery completion</p>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>Consignment</h3>
                <p><strong>Reference #:</strong> {{ $consignment->reference_no }}</p>
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $consignment->status)) }}</p>
                <p><strong>Delivered At:</strong> {{ optional($consignment->delivered_at)->format('F d, Y h:i A') ?? 'N/A' }}</p>
            </div>
            <div class="info-card">
                <h3>Vendor</h3>
                <p><strong>Name:</strong> {{ $consignment->vendor->name ?? 'N/A' }}</p>
                <p><strong>Code:</strong> {{ $consignment->vendor->code ?? 'N/A' }}</p>
                <p><strong>Contact:</strong> {{ $consignment->vendor->contact_name ?? 'N/A' }}</p>
            </div>
            <div class="info-card">
                <h3>Vehicle</h3>
                <p><strong>Plate #:</strong> {{ $consignment->vehicle->plate_number ?? 'N/A' }}</p>
                <p><strong>Driver:</strong> {{ $consignment->vehicle->driver_name ?? 'N/A' }}</p>
                <p><strong>Driver Phone:</strong> {{ $consignment->vehicle->driver_phone ?? 'N/A' }}</p>
            </div>
        </div>

        @if(!empty($consignment->notes))
            <div class="info-card" style="margin-bottom: 16px;">
                <h3>Notes</h3>
                <p>{{ $consignment->notes }}</p>
            </div>
        @endif

        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Extra Expenses</th>
                    <th>Commission %</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consignment->items as $index => $item)
                    @php
                        $lineTotal = (float) $item->unit_price * $item->quantity;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->sku ?? '-' }}</td>
                        <td>{{ $item->category->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format((float) $item->unit_price, 2) }}</td>
                        <td>${{ number_format((float) ($item->extra_expences ?? 0), 2) }}</td>
                        <td>{{ $item->commission_rate }}%</td>
                        <td>${{ number_format($lineTotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <strong>Total Quantity:</strong>
                <span>{{ number_format($summary['total_quantity'] ?? 0) }}</span>
            </div>
            <div class="summary-row">
                <strong>Total Item Value:</strong>
                <span>${{ number_format($summary['total_value'] ?? 0, 2) }}</span>
            </div>
            <div class="summary-row">
                <strong>Total Extra Expenses:</strong>
                <span>${{ number_format($summary['total_extra_expenses'] ?? 0, 2) }}</span>
            </div>
            <div class="summary-row">
                <strong>Total Commission (Estimated):</strong>
                <span>${{ number_format($summary['total_commission'] ?? 0, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>This receipt confirms that the consignment has been delivered and received by the driver.</p>
            <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>

