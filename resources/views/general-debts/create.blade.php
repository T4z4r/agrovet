@extends('layouts.master')

@section('title', 'Create General Debt')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create General Debt</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.general-debts.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="shop_id" class="form-label">Shop</label>
                            <select class="form-control" id="shop_id" name="shop_id" required>
                                <option value="">Select Shop</option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>{{ $shop->name }}</option>
                                @endforeach
                            </select>
                            @error('shop_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="debtor_name" class="form-label">Debtor Name</label>
                            <input type="text" class="form-control" id="debtor_name" name="debtor_name" value="{{ old('debtor_name') }}" placeholder="Enter debtor or customer name" required>
                            @error('debtor_name')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="debtor_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="debtor_phone" name="debtor_phone" value="{{ old('debtor_phone') }}" placeholder="e.g. 0712 345 678">
                            @error('debtor_phone')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="debtor_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="debtor_email" name="debtor_email" value="{{ old('debtor_email') }}" placeholder="e.g. customer@example.com">
                            @error('debtor_email')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" min="0.01" step="0.01" placeholder="0.00" required>
                            @error('amount')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="debt_date" class="form-label">Debt Date</label>
                            <input type="date" class="form-control" id="debt_date" name="debt_date" value="{{ old('debt_date', date('Y-m-d')) }}" required>
                            @error('debt_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
                            @error('due_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter what this debt is for">{{ old('description') }}</textarea>
                            @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('web.general-debts.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
