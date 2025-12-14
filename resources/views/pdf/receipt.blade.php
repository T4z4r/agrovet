<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agrovet Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .receipt-info div {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #007bff;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Agrovet</h1>
        <p>Quality Agricultural Products</p>
        <p>Receipt</p>
    </div>

    <div class="receipt-info">
        <div>
            <strong>Sale #:</strong> {{ $sale->id }}<br>
            <strong>Date:</strong> {{ $sale->sale_date->format('d/m/Y') }}<br>
            <strong>Seller:</strong> {{ $sale->seller->name }}
        </div>
        <div style="text-align: right;">
            <strong>Time:</strong> {{ $sale->created_at->format('H:i:s') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $i)
            <tr>
                <td>{{ $i->product->name }}</td>
                <td>{{ $i->quantity }}</td>
                <td>KSh {{ number_format($i->price, 2) }}</td>
                <td>KSh {{ number_format($i->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Grand Total: KSh {{ number_format($sale->total, 2) }}
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>Visit us again at Agrovet</p>
    </div>
</body>
</html>
