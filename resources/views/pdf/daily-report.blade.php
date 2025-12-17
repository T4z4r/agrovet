<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agrovet Daily Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1200px;
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
        .report-info {
            text-align: center;
            margin-bottom: 20px;
            background-color: #f1f8e9;
            padding: 10px;
            border-radius: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 10px;
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
        .sale-header {
            background-color: #e3f2fd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('assets/img/logo.png') }}" alt="Agrovet Logo">
            <h1>Kendrick Agrovet</h1>
            <p>Quality Agricultural Products</p>
            <p>Daily Report</p>
        </div>

        <div class="report-info">
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        </div>

        <div class="section">
            <h2>Sales</h2>
            @if($sales->count() > 0)
                @foreach($sales as $sale)
                    <div class="sale-header">
                        <strong>Sale #{{ $sale->id }}</strong> - Seller: {{ $sale->seller->name }} - Time: {{ $sale->created_at->format('H:i:s') }}
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
                            @foreach($sale->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>TSh {{ number_format($item->price, 2) }}</td>
                                <td>TSh {{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="total">
                        Sale Total: TSh {{ number_format($sale->total, 2) }}
                    </div>
                @endforeach
                <div class="total">
                    Total Sales: TSh {{ number_format($total_sales, 2) }}
                </div>
            @else
                <p>No sales for this date.</p>
            @endif
        </div>

        <div class="section">
            <h2>Expenses</h2>
            @if($expenses->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->category }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>TSh {{ number_format($expense->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="total">
                    Total Expenses: TSh {{ number_format($total_expenses, 2) }}
                </div>
            @else
                <p>No expenses for this date.</p>
            @endif
        </div>

        <div class="footer">
            <p>Generated on {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>Agrovet Daily Report</p>
        </div>
    </div>
</body>
</html>
