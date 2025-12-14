@extends('layouts.master')

@section('title', 'Expenses')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Expenses</h5>
                <a href="{{ route('web.expenses.create') }}" class="btn btn-primary">Add Expense</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Shop</th>
                                <th>Recorded By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                            <tr>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->date }}</td>
                                <td>{{ $expense->shop->name }}</td>
                                <td>{{ $expense->recordedBy->name }}</td>
                                <td>
                                    <a href="{{ route('web.expenses.show', $expense) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.expenses.edit', $expense) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('web.expenses.destroy', $expense) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
