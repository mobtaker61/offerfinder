@extends('layouts.admin')

@section('title', 'Districts Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Districts</h1>
                <a href="{{ route('admin.districts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New District
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Local Name</th>
                            <th>Emirate</th>
                            <th>Coordinates</th>
                            <th>Status</th>
                            <th>Manage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($districts as $district)
                        <tr>
                            <td>{{ $district->id }}</td>
                            <td>{{ $district->name }}</td>
                            <td>{{ $district->local_name }}</td>
                            <td>{{ $district->emirate->name }}</td>
                            <td>
                                @if($district->latitude && $district->longitude)
                                {{ number_format($district->latitude, 6) }}, {{ number_format($district->longitude, 6) }}
                                @else
                                <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $district->is_active ? 'success' : 'danger' }}">
                                    {{ $district->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.neighbours.index', ['district_id' => $district->id]) }}" class="btn btn-info btn-sm" title="Manage Neighbours">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.markets.index', ['district_id' => $district->id]) }}" class="btn btn-primary btn-sm" title="Manage Markets">
                                        <i class="fas fa-store"></i>
                                    </a>
                                    <a href="{{ route('admin.offers.index', ['district_id' => $district->id]) }}" class="btn btn-success btn-sm" title="Manage Offers">
                                        <i class="fas fa-tags"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.districts.edit', $district) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.districts.destroy', $district) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this district?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No districts found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $districts->links() }}
        </div>
    </div>
</div>
@endsection