@extends('layouts.master')

@section('title', 'Audit Logs')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Audit Logs</h5>
                <small>View all audit records of changes in the system.</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Event</th>
                                <th>Model</th>
                                <th>User</th>
                                <th>Old Values</th>
                                <th>New Values</th>
                                <th>IP Address</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($audits as $audit)
                            <tr>
                                <td>{{ $audit->id }}</td>
                                <td>{{ ucfirst($audit->event) }}</td>
                                <td>{{ $audit->auditable_type }} (ID: {{ $audit->auditable_id }})</td>
                                <td>{{ $audit->user ? $audit->user->name : 'System' }}</td>
                                <td>
                                    @if($audit->old_values)
                                        <details>
                                            <summary>View Changes</summary>
                                            <pre>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</pre>
                                        </details>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($audit->new_values)
                                        <details>
                                            <summary>View Changes</summary>
                                            <pre>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</pre>
                                        </details>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $audit->ip_address }}</td>
                                <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No audit records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $audits->links() }}
            </div>
        </div>
    </div>
</div>
@endsection