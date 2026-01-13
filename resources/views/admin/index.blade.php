@extends('layouts.master')

@section('title', 'Database Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Database Tables</h5>
                <small>Clear system data from tables below. This action is irreversible.</small>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Table Name</th>
                                <th>Records Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tableData as $table)
                            <tr>
                                <td>{{ $table['name'] }}</td>
                                <td>{{ number_format($table['count']) }}</td>
                                <td>
                                    @if($table['count'] > 0)
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" data-table="{{ $table['name'] }}">Clear Data</button>
                                    @else
                                        <span class="text-muted">No data</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Confirm Data Clearing</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to clear all data from table <strong id="tableName"></strong>?</p>
                                <p class="text-danger"><strong>This action is irreversible and cannot be undone!</strong></p>
                                <p>Please confirm your password and type <strong>"CONFIRM"</strong> to proceed:</p>
                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">Password</label>
                                    <input type="password" id="passwordInput" class="form-control" placeholder="Enter your password">
                                </div>
                                <div class="mb-3">
                                    <label for="otpInput" class="form-label">OTP Code</label>
                                    <div class="input-group">
                                        <input type="text" id="otpInput" class="form-control" placeholder="Enter OTP code">
                                        <button class="btn btn-outline-secondary" type="button" id="sendOtpBtn">Send OTP</button>
                                    </div>
                                    <small class="text-muted" id="otpMessage">Click "Send OTP" to receive a code.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmInput" class="form-label">Confirmation</label>
                                    <input type="text" id="confirmInput" class="form-control" placeholder="Type CONFIRM">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmBtn" disabled>Clear Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    var selectedTable = '';

    $('#confirmModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        selectedTable = button.data('table');
        $('#tableName').text(selectedTable);
        $('#passwordInput').val('');
        $('#otpInput').val('');
        $('#confirmInput').val('');
        $('#otpMessage').text('Click "Send OTP" to receive a code.');
        $('#confirmBtn').prop('disabled', true);
    });

    $('#sendOtpBtn').on('click', function() {
        // Send AJAX to generate OTP
        $.post('{{ route("web.admin.sendOtp") }}', {
            _token: '{{ csrf_token() }}'
        }).done(function(response) {
            $('#otpMessage').text('OTP sent successfully.');
        }).fail(function() {
            $('#otpMessage').text('Failed to send OTP.');
        });
    });

    $('#passwordInput, #otpInput, #confirmInput').on('input', function() {
        var password = $('#passwordInput').val();
        var otp = $('#otpInput').val();
        var confirm = $('#confirmInput').val().toUpperCase();
        if (password.length > 0 && otp.length > 0 && confirm === 'CONFIRM') {
            $('#confirmBtn').prop('disabled', false);
        } else {
            $('#confirmBtn').prop('disabled', true);
        }
    });

    $('#confirmBtn').on('click', function() {
        // Create and submit form
        var form = $('<form>', {
            'method': 'POST',
            'action': '{{ url("admin/clear") }}/' + selectedTable
        });
        form.append($('<input>', {
            'type': 'hidden',
            'name': '_token',
            'value': '{{ csrf_token() }}'
        }));
        form.append($('<input>', {
            'type': 'hidden',
            'name': 'password',
            'value': $('#passwordInput').val()
        }));
        form.append($('<input>', {
            'type': 'hidden',
            'name': 'otp',
            'value': $('#otpInput').val()
        }));
        $('body').append(form);
        form.submit();
    });
});
</script>
@endsection
