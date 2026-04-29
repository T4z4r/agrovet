@extends('layouts.master')

@section('title', 'General Debt Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Debt Details</h5>
                <span class="badge bg-label-{{ $debt->status === 'paid' ? 'success' : ($debt->status === 'partial' ? 'warning' : 'danger') }}">{{ ucfirst($debt->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><strong>Debtor:</strong> {{ $debt->debtor_name }}</div>
                    <div class="col-md-6"><strong>Shop:</strong> {{ optional($debt->shop)->name ?: 'N/A' }}</div>
                    <div class="col-md-6"><strong>Phone:</strong> {{ $debt->debtor_phone ?: 'N/A' }}</div>
                    <div class="col-md-6"><strong>Email:</strong> {{ $debt->debtor_email ?: 'N/A' }}</div>
                    <div class="col-md-4"><strong>Amount:</strong> {{ number_format($debt->amount, 2) }}</div>
                    <div class="col-md-4"><strong>Paid:</strong> {{ number_format($debt->amount_paid, 2) }}</div>
                    <div class="col-md-4"><strong>Balance:</strong> {{ number_format($debt->balance, 2) }}</div>
                    <div class="col-md-6"><strong>Debt Date:</strong> {{ optional($debt->debt_date)->format('Y-m-d') }}</div>
                    <div class="col-md-6"><strong>Due Date:</strong> {{ optional($debt->due_date)->format('Y-m-d') ?: 'N/A' }}</div>
                    <div class="col-12"><strong>Description:</strong> {{ $debt->description ?: 'N/A' }}</div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('web.general-debts.edit', $debt) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.general-debts.index') }}" class="btn btn-secondary">Back to Debts</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Recorded By</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($debt->payments->sortByDesc('payment_date') as $payment)
                                <tr>
                                    <td>{{ optional($payment->payment_date)->format('Y-m-d') }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_method ?: 'N/A' }}</td>
                                    <td>{{ optional($payment->recordedBy)->name ?: 'N/A' }}</td>
                                    <td>{{ $payment->notes ?: 'N/A' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('web.general-debts.payments.destroy', [$debt, $payment]) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No payments recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Record Payment</h5>
            </div>
            <div class="card-body">
                @if($debt->balance > 0)
                    <form method="POST" action="{{ route('web.general-debts.payments.store', $debt) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="0.01" max="{{ $debt->balance }}" step="0.01" value="{{ old('amount') }}" placeholder="0.00" required>
                            @error('amount')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                            @error('payment_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="payment_method" name="payment_method" value="{{ old('payment_method') }}" placeholder="e.g. Cash, M-Pesa, Bank transfer">
                            @error('payment_method')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" placeholder="Add payment reference or notes">{{ old('notes') }}</textarea>
                            @error('notes')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Record Payment</button>
                    </form>
                @else
                    <div class="alert alert-success mb-0">This debt is fully paid.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
