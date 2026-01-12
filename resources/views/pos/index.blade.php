@extends('layouts.master')

@section('title', 'Point of Sale')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Products</h5>
                <div class="mt-3">
                    <input type="text" id="product-search" class="form-control" placeholder="Search products...">
                </div>
            </div>
            <div class="card-body">
                <div class="row" id="products-grid">
                    @foreach($products as $product)
                        <div class="col-md-3 mb-3">
                            <div class="card product-card" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock }}">
                                <div class="card-body text-center">
                                    <h6>{{ $product->name }}</h6>
                                    <p class="text-muted">{{ $product->selling_price }} Tsh</p>
                                    <p class="small">Stock: {{ $product->stock }}</p>
                                    <button class="btn btn-primary btn-sm add-to-cart" {{ $product->stock <= 0 ? 'disabled' : '' }}>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cart</h5>
            </div>
            <div class="card-body">
                <div id="cart-items">
                    <!-- Cart items will be added here -->
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong id="total">0.00 Tsh</strong>
                </div>
                <form id="checkout-form" method="POST" action="{{ route('web.pos.store') }}">
                    @csrf
                    <input type="hidden" name="items" id="items-input">
                    <div class="mt-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method">
                            <option value="">Select Payment Method</option>
                            <option value="cash">Cash</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="customer_name" class="form-label">Customer Name (Optional)</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name">
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-3" id="checkout-btn" disabled>Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 on payment method dropdown
    $('#payment_method').select2({
        placeholder: "Select Payment Method",
        allowClear: true
    });

    let cart = [];
    let total = 0;

    // Search functionality
    const searchInput = document.getElementById('product-search');
    const productCards = document.querySelectorAll('.product-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        productCards.forEach(card => {
            const productName = card.dataset.name.toLowerCase();
            if (productName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input')) {
            const index = e.target.dataset.index;
            const newQty = parseInt(e.target.value);
            if (isNaN(newQty) || newQty < 1 || newQty > cart[index].stock) {
                e.target.value = cart[index].quantity;
                alert('Invalid quantity');
                return;
            }
            cart[index].quantity = newQty;
            updateCart();
        }
    });

    function updateCart() {
        const cartItemsDiv = document.getElementById('cart-items');
        cartItemsDiv.innerHTML = '';
        total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.quantity * item.price;
            total += itemTotal;

            const itemDiv = document.createElement('div');
            itemDiv.className = 'd-flex justify-content-between align-items-center mb-2';
            itemDiv.innerHTML = `
                <div>
                    <strong>${item.name}</strong><br>
                    <small>
                        <button class="btn btn-sm btn-secondary minus-qty" data-index="${index}">-</button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="btn btn-sm btn-secondary plus-qty" data-index="${index}">+</button>
                        x ${item.price} = ${itemTotal.toFixed(2)} Tsh
                    </small>
                </div>
                <button class="btn btn-sm btn-danger remove-item" data-index="${index}">Remove</button>
            `;
            cartItemsDiv.appendChild(itemDiv);
        });

        document.getElementById('total').textContent = total.toFixed(2) + ' Tsh';
        document.getElementById('checkout-btn').disabled = cart.length === 0;

        // Update hidden input
        document.getElementById('items-input').value = JSON.stringify(cart.map(item => ({
            product_id: item.id,
            quantity: item.quantity,
            price: item.price
        })));
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            const card = e.target.closest('.product-card');
            const id = card.dataset.id;
            const name = card.dataset.name;
            const price = parseFloat(card.dataset.price);
            const stock = parseInt(card.dataset.stock);

            // Check if already in cart
            let existingItem = cart.find(item => item.id == id);
            if (existingItem) {
                if (existingItem.quantity < existingItem.stock) {
                    existingItem.quantity++;
                } else {
                    alert('Insufficient stock');
                    return;
                }
            } else {
                cart.push({ id, name, price, quantity: 1, stock });
            }

            updateCart();
        }

        if (e.target.classList.contains('remove-item')) {
            const index = e.target.dataset.index;
            cart.splice(index, 1);
            updateCart();
        }
        if (e.target.classList.contains('plus-qty')) {
            const index = e.target.dataset.index;
            if (cart[index].quantity < cart[index].stock) {
                cart[index].quantity++;
                updateCart();
            } else {
                alert('Insufficient stock');
            }
        }
        if (e.target.classList.contains('minus-qty')) {
            const index = e.target.dataset.index;
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
                updateCart();
            }
        }
    });
});
</script>
@endsection
