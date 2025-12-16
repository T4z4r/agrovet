@extends('layouts.master')

@section('title', 'Sales')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales</h5>
                <a href="{{ route('web.sales.create') }}" class="btn btn-primary">Add Sale</a>
            </div>
            <!--Search Form -->
            <div class="card-body">
                <form class="dt_adv_search" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Sale ID:</label>
                                    <input
                                        type="text"
                                        class="form-control dt-input"
                                        data-column="0"
                                        placeholder="Sale ID"
                                        data-column-index="0"
                                    />
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Seller:</label>
                                    <input
                                        type="text"
                                        class="form-control dt-input"
                                        data-column="1"
                                        placeholder="Seller Name"
                                        data-column-index="1"
                                    />
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Total:</label>
                                    <input
                                        type="text"
                                        class="form-control dt-input"
                                        data-column="2"
                                        placeholder="Total Amount"
                                        data-column-index="2"
                                    />
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label class="form-label">Date:</label>
                                    <div class="mb-0">
                                        <input
                                            type="text"
                                            class="form-control dt-date flatpickr-range dt-input"
                                            data-column="3"
                                            placeholder="StartDate to EndDate"
                                            data-column-index="3"
                                            name="dt_date"
                                        />
                                        <input
                                            type="hidden"
                                            class="form-control dt-date start_date dt-input"
                                            data-column="3"
                                            data-column-index="3"
                                            name="value_from_start_date"
                                        />
                                        <input
                                            type="hidden"
                                            class="form-control dt-date end_date dt-input"
                                            name="value_from_end_date"
                                            data-column="3"
                                            data-column-index="3"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr class="mt-0" />
            <div class="card-datatable table-responsive">
                <table class="dt-advanced-search table border-top">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Seller</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Seller</th>
                            <th>Total</th>
                            <th>Date</th>
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
    $('.dt-advanced-search').DataTable({
        ajax: {
            url: '{{ route("web.sales.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: null, defaultContent: '', orderable: false },
            { data: 'id' },
            { data: 'seller.name' },
            { data: 'total' },
            { data: 'sale_date' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('sales') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('sales') }}/${data}/receipt" class="btn btn-sm btn-secondary">Receipt</a>
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
        orderCellsTop: true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of Sale #' + data['id'];
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
