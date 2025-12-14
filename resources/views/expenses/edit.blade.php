@extends('layouts.master')

@section('title', 'Edit Expense')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Expense</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.expenses.update', $expense) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="shop_id" class="form-label">Shop</label>
                            <select class="form-control" id="shop_id" name="shop_id" required>
                                <option value="">Select Shop</option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}" {{ $expense->shop_id == $shop->id ? 'selected' : '' }}>{{ $shop->name }}</option>
                                @endforeach
                            </select>
                            @error('shop_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $expense->category) }}" required>
                            @error('category')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required min="0" step="0.01">
                            @error('amount')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $expense->date) }}" required>
                            @error('date')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $expense->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('web.expenses.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection