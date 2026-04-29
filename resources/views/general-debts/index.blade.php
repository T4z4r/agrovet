@extends('layouts.master')

@section('title', 'General Debts')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">General Debts</h5>
                <a href="{{ route('web.general-debts.create') }}" class="btn btn-primary">Add Debt</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Debtor</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Debt Date</th>
                                <th>Due Date</th>
                                <th>Shop</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($debts as $debt)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $debt->debtor_name }}</div>
                                        <small class="text-muted">{{ $debt->debtor_phone ?: $debt->debtor_email }}</small>
                                    </td>
                                    <td>{{ number_format($debt->amount, 2) }}</td>
                                    <td>{{ number_format($debt->amount_paid, 2) }}</td>
                                    <td>{{ number_format($debt->balance, 2) }}</td>
                                    <td>
                                        <span class="badge bg-label-{{ $debt->status === 'paid' ? 'success' : ($debt->status === 'partial' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($debt->status) }}
                                        </span>
                                    </td>
                                    <td>{{ optional($debt->debt_date)->format('Y-m-d') }}</td>
                                    <td>{{ optional($debt->due_date)->format('Y-m-d') ?: 'N/A' }}</td>
                                    <td>{{ optional($debt->shop)->name ?: 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('web.general-debts.show', $debt) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('web.general-debts.edit', $debt) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('web.general-debts.destroy', $debt) }}" class="d-inline" id="delete-form-{{ $debt->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $debt->id }})">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No general debts recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will also delete all payments for this debt.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d6d6d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
