@extends('layouts.master')

@section('title', 'Suppliers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Suppliers</h5>
                <a href="{{ route('web.suppliers.create') }}" class="btn btn-primary">Add Supplier</a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="dt-responsive table border-top">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dt-responsive').DataTable({
        ajax: {
            url: '{{ route("web.suppliers.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: null, defaultContent: '', orderable: false },
            { data: 'name' },
            { data: 'phone' },
            { data: 'email' },
            { data: 'address' },
            {
                data: 'is_active',
                render: function(data, type, row) {
                    var status = data == 1 ? 'Active' : 'Inactive';
                    var badgeClass = data == 1 ? 'bg-label-success' : 'bg-label-danger';
                    return '<span class="badge rounded-pill ' + badgeClass + '">' + status + '</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('suppliers') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('suppliers') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('suppliers') }}/${data}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    `;
                }
            }
        ],
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                targets: 0,
                render: function (data, type, full, meta) {
                    return '';
                }
            }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of ' + data['name'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        }
    });
});
</script>
@endsection
