<h3>Agrovet Receipt</h3>
<p>Sale #: {{ $sale->id }}</p>
<p>Date: {{ $sale->sale_date }}</p>

<table width="100%">
<tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
@foreach($sale->items as $i)
<tr>
<td>{{ $i->product->name }}</td>
<td>{{ $i->quantity }}</td>
<td>{{ number_format($i->price) }}</td>
<td>{{ number_format($i->total) }}</td>
</tr>
@endforeach
</table>

<h3>Total: {{ number_format($sale->total) }}</h3>
