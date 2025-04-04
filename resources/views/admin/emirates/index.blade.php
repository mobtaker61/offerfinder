@extends('layouts.admin')

@section('title', 'Emirates Management')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Emirates</h1>
                <a href="{{ route('admin.emirates.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Emirate
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
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
                        @forelse ($emirates as $emirate)
                        <tr>
                            <td>{{ $emirate->name }}</td>
                            <td>{{ $emirate->local_name ?? '-' }}</td>
                            <td>
                                @if($emirate->latitude && $emirate->longitude)
                                {{ number_format($emirate->latitude, 6) }}, {{ number_format($emirate->longitude, 6) }}
                                @else
                                <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $emirate->is_active ? 'success' : 'danger' }}">
                                    {{ $emirate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Manage buttons">
                                    <a href="{{ route('admin.districts.index', ['emirate_id' => $emirate->id]) }}" 
                                       class="btn btn-info btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Manage Districts">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.markets.index', ['emirate_id' => $emirate->id]) }}" 
                                       class="btn btn-primary btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Manage Markets">
                                        <i class="fas fa-store"></i>
                                    </a>
                                    <a href="{{ route('admin.offers.index', ['emirate_id' => $emirate->id]) }}" 
                                       class="btn btn-success btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Manage Offers">
                                        <i class="fas fa-tags"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action buttons">
                                    <a href="{{ route('admin.emirates.edit', $emirate->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit Emirate">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.emirates.destroy', $emirate->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this emirate?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete Emirate">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No emirates found.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $emirates->links('vendor.pagination.bootstrap-5') }}
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