@extends('layouts.admin')

@section('title', 'Market List')

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

    /* Market specific styles */
    .img-thumbnail {
        max-width: 100px;
        height: auto;
    }

    .form-switch {
        padding-left: 2.5em;
    }

    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
        margin-left: -2.5em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Market List</h1>
                <a href="{{ route('admin.markets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Market
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
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Local Name</th>
                            <th>Website</th>
                            <th>Apps</th>
                            <th>WhatsApp</th>
                            <th>Status</th>
                            <th>Plan</th>
                            <th>Manage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($markets as $market)
                        <tr>
                            <td class="text-center">
                                @if($market->logo)
                                <img src="{{ asset('storage/' . $market->logo) }}" alt="{{ $market->name }}" class="img-thumbnail">
                                @else
                                <div class="text-muted">No Logo</div>
                                @endif
                            </td>
                            <td>{{ $market->name }}</td>
                            <td>{{ $market->local_name ?? '-' }}</td>
                            <td>
                                @if($market->website)
                                <a href="{{ $market->website }}" target="_blank" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Visit Website">
                                    <i class="fas fa-globe"></i> Visit Website
                                </a>
                                @else
                                <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="App links">
                                    @if($market->android_app_link)
                                    <a href="{{ $market->android_app_link }}" target="_blank" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Android App">
                                        <i class="fab fa-android"></i>
                                    </a>
                                    @endif
                                    @if($market->ios_app_link)
                                    <a href="{{ $market->ios_app_link }}" target="_blank" class="btn btn-sm btn-outline-dark" data-bs-toggle="tooltip" title="iOS App">
                                        <i class="fab fa-apple"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($market->whatsapp)
                                <a href="https://wa.me/{{ $market->whatsapp }}" target="_blank" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Contact on WhatsApp">
                                    <i class="fab fa-whatsapp"></i> Contact
                                </a>
                                @else
                                <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input status-toggle" type="checkbox" data-market-id="{{ $market->id }}" {{ $market->is_active ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                @if($market->plan)
                                    <span class="badge bg-success">{{ $market->plan->name }}</span>
                                @else
                                    <span class="badge bg-secondary">No Plan</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Manage buttons">
                                    <a href="{{ route('admin.branches.index', ['market_id' => $market->id]) }}" 
                                       class="btn btn-info btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Manage Branches">
                                        <i class="fas fa-store"></i>
                                    </a>
                                    <a href="{{ route('admin.offers.index', ['market_id' => $market->id]) }}" 
                                       class="btn btn-success btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Manage Offers">
                                        <i class="fas fa-tags"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action buttons">
                                    <a href="{{ route('admin.markets.edit', $market->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit Market">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.markets.destroy', $market->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this market?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete Market">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No markets found.
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
                        <option value="{{ route('admin.markets.index', ['per_page' => 10]) }}" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ route('admin.markets.index', ['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ route('admin.markets.index', ['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="{{ route('admin.markets.index', ['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="ms-2 text-muted">entries</span>
                </div>
                <div>
                    {{ $markets->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
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

    // Handle status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const marketId = this.dataset.marketId;
            const isActive = this.checked;

            fetch(`/admin/markets/${marketId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    this.checked = !isActive;
                    alert(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !isActive;
                alert('Failed to update status');
            });
        });
    });
});
</script>
@endsection