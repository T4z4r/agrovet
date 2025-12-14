@extends('layouts.master')

@section('title', 'Expense Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Expense Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Category:</strong> {{ $expense->category }}
                    </div>
                    <div class="col-md-6">
                        <strong>Amount:</strong> {{ $expense->amount }}
                    </div>
                    <div class="col-md-6">
                        <strong>Date:</strong> {{ $expense->date }}
                    </div>
                    <div class="col-md-6">
                        <strong>Shop:</strong> {{ $expense->shop->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Recorded By:</strong> {{ $expense->recordedBy->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Description:</strong> {{ $expense->description ?: 'N/A' }}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('web.expenses.edit', $expense) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.expenses.index') }}" class="btn btn-secondary">Back to Expenses</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
