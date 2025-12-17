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
                                        <form method="POST" action="{{ route('web.admin.clear', $table['name']) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to clear all data from {{ $table['name'] }}? This action cannot be undone.')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Clear Data</button>
                                        </form>
                                    @else
                                        <span class="text-muted">No data</span>
                                    @endif
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