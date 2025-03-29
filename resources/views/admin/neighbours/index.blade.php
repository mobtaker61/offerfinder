@extends('layouts.admin')

@section('title', 'Neighbours Management')

@section('styles')
<style>
    /* Consistent table styles */
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

    /* Neighbour specific styles */
    .badge {
        font-weight: 500;
    }

    /* Link styles */
    .table-link {
        color: #4e73df;
        text-decoration: none;
    }
    
    .table-link:hover {
        color: #224abe;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Neighbours</h1>
                    @if(request('district_id'))
                        <small class="text-muted">
                            Showing neighbours for {{ \App\Models\District::find(request('district_id'))->name }}
                            <a href="{{ route('admin.neighbours.index') }}" class="ms-2">
                                <i class="fas fa-times"></i> Clear filter
                            </a>
                        </small>
                    @endif
                </div>
                <a href="{{ route('admin.neighbours.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Neighbour
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Local Name</th>
                            <th>Emirate</th>
                            <th>District</th>
                            <th>Coordinates</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($neighbours as $neighbour)
                        <tr>
                            <td>{{ $neighbour->id }}</td>
                            <td>{{ $neighbour->name }}</td>
                            <td>{{ $neighbour->local_name }}</td>
                            <td>{{ $neighbour->district->emirate->name }}</td>
                            <td>{{ $neighbour->district->name }}</td>
                            <td>
                                @if($neighbour->latitude && $neighbour->longitude)
                                {{ number_format($neighbour->latitude, 6) }}, {{ number_format($neighbour->longitude, 6) }}
                                @else
                                <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $neighbour->is_active ? 'success' : 'danger' }}">
                                    {{ $neighbour->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action buttons">
                                    <a href="{{ route('admin.neighbours.edit', $neighbour) }}"
                                       class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit Neighbour">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.neighbours.destroy', $neighbour) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this neighbour?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete Neighbour">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No neighbours found.
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
                        <option value="{{ route('admin.neighbours.index', ['per_page' => 10]) }}" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ route('admin.neighbours.index', ['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ route('admin.neighbours.index', ['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="{{ route('admin.neighbours.index', ['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="ms-2 text-muted">entries</span>
                </div>
                <div>
                    {{ $neighbours->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection