@extends('layouts.admin')

@section('title', 'Districts Management')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Districts</h1>
                    @if(request('emirate_id'))
                        <small class="text-muted">
                            Showing districts for {{ \App\Models\Emirate::find(request('emirate_id'))->name }}
                            <a href="{{ route('admin.districts.index') }}" class="ms-2">
                                <i class="fas fa-times"></i> Clear filter
                            </a>
                        </small>
                    @endif
                </div>
                <a href="{{ route('admin.districts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New District
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
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
                                <div class="btn-group" role="group" aria-label="Manage buttons">
                                    <a href="{{ route('admin.neighbours.index', ['district_id' => $district->id]) }}" 
                                       class="btn btn-info btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       title="Manage Neighbours">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.markets.index', ['district_id' => $district->id]) }}" 
                                       class="btn btn-primary btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       title="Manage Markets">
                                        <i class="fas fa-store"></i>
                                    </a>
                                    <a href="{{ route('admin.offers.index', ['district_id' => $district->id]) }}" 
                                       class="btn btn-success btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       title="Manage Offers">
                                        <i class="fas fa-tags"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action buttons">
                                    <a href="{{ route('admin.districts.edit', $district) }}"
                                       class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit District">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.districts.destroy', $district) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this district?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete District">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No districts found.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <label class="me-2 mb-0">Show:</label>
                    <select class="form-select form-select-sm" style="width: 80px;" onchange="window.location.href=this.value">
                        <option value="{{ route('admin.districts.index', ['per_page' => 10]) }}" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ route('admin.districts.index', ['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ route('admin.districts.index', ['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="{{ route('admin.districts.index', ['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="ms-2 text-muted">entries</span>
                </div>
                <div>
                    {{ $districts->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin: 0 2px;
    }
    
    .btn-group .btn:first-child {
        margin-left: 0;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
    }
    
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e3e6f0;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection