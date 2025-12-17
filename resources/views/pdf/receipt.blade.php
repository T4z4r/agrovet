<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agrovet Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header img {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #4CAF50;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #f1f8e9;
            padding: 10px;
            border-radius: 5px;
        }
        .receipt-info div {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 20px;
            padding: 10px;
            background-color: #e8f5e8;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #4CAF50;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('assets/img/logo.png') }}" alt="Agrovet Logo">
            <h1>Kendrick Agrovet</h1>
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
                <td>TSh {{ number_format($i->price, 2) }}</td>
                <td>TSh {{ number_format($i->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Grand Total: TSh {{ number_format($sale->total, 2) }}
    </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Visit us again at Agrovet</p>
        </div>
    </div>
</body>
</html>
