@extends('layouts.admin')

@section('title', 'Emirates Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Emirates</h1>
                <a href="{{ route('admin.emirates.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Emirate
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Local Name</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Manage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emirates as $emirate)
                        <tr>
                            <td>{{ $emirate->name }}</td>
                            <td>{{ $emirate->local_name ?? '-' }}</td>
                            <td>
                                @if($emirate->latitude && $emirate->longitude)
                                {{ number_format($emirate->latitude, 6) }}, {{ number_format($emirate->longitude, 6) }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $emirate->is_active ? 'success' : 'danger' }}">
                                    {{ $emirate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.districts.index', ['emirate_id' => $emirate->id]) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.markets.index', ['emirate_id' => $emirate->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-store"></i>
                                    </a>
                                    <a href="{{ route('admin.offers.index', ['emirate_id' => $emirate->id]) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-tags"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.emirates.edit', $emirate->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.emirates.destroy', $emirate->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection