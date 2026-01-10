@extends('layouts.master')

@section('title', 'Subscription Payments')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Subscription Payments</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Payment</button>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Shop</th>
                            <th>Subscription</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Shop</th>
                            <th>Subscription</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Subscription Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_subscription_id" class="form-label">Subscription</label>
                        <select class="form-control" id="create_subscription_id" name="subscription_id" required>
                            <option value="">Select Subscription</option>
                            @foreach($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}">{{ $subscription->shop->name }} - {{ $subscription->subscriptionPackage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="create_amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_payment_date" class="form-label">Payment Date</label>
                        <input type="date" class="form-control" id="create_payment_date" name="payment_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_status" class="form-label">Status</label>
                        <select class="form-control" id="create_status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_payment_method" class="form-label">Payment Method</label>
                        <input type="text" class="form-control" id="create_payment_method" name="payment_method">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Subscription Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_subscription_id" class="form-label">Subscription</label>
                        <select class="form-control" id="edit_subscription_id" name="subscription_id" required>
                            <option value="">Select Subscription</option>
                            @foreach($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}">{{ $subscription->shop->name }} - {{ $subscription->subscriptionPackage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="edit_amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_payment_date" class="form-label">Payment Date</label>
                        <input type="date" class="form-control" id="edit_payment_date" name="payment_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_payment_method" class="form-label">Payment Method</label>
                        <input type="text" class="form-control" id="edit_payment_method" name="payment_method">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var table = $('.dt-column-search').DataTable({
        ajax: {
            url: '{{ route("admin.subscription-payments.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'subscription.shop.name' },
            { data: 'subscription.subscription_package.name' },
            { data: 'amount' },
            { data: 'payment_date' },
            { data: 'status' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('admin/subscription-payments') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <button type="button" class="btn btn-sm btn-warning edit-btn" data-id="${data}">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                    `;
                }
            }
        ],
        orderCellsTop: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
    });

    // Create form submit
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.subscription-payments.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#createModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                    $('#createForm')[0].reset();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                for (var field in errors) {
                    alert(errors[field][0]);
                }
            }
        });
    });

    // Edit button click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/subscription-payments") }}/' + id + '/edit',
            type: 'GET',
            success: function(data) {
                $('#edit_id').val(data.id);
                $('#edit_subscription_id').val(data.subscription_id);
                $('#edit_amount').val(data.amount);
                $('#edit_payment_date').val(data.payment_date);
                $('#edit_status').val(data.status);
                $('#edit_payment_method').val(data.payment_method);
                $('#editModal').modal('show');
            }
        });
    });

    // Edit form submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        $.ajax({
            url: '{{ url("admin/subscription-payments") }}/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                for (var field in errors) {
                    alert(errors[field][0]);
                }
            }
        });
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this payment?')) {
            $.ajax({
                url: '{{ url("admin/subscription-payments") }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});
</script>
@endsection
