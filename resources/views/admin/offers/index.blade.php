@extends('layouts.admin')

@section('title', 'Offers Management')

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

    /* Offer specific styles */
    .offer-image {
        max-width: 100px;
        height: auto;
        object-fit: cover;
    }

    .badge {
        font-weight: 500;
    }

    .filter-section {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Offers Management</h1>
                <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Offer
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

            <!-- Filters -->
            <div class="filter-section">
                <form action="{{ route('admin.offers.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="market" class="form-label">Market</label>
                        <select name="market_id" id="market" class="form-select">
                            <option value="">All Markets</option>
                            @foreach($markets as $market)
                                <option value="{{ $market->id }}" {{ request('market_id') == $market->id ? 'selected' : '' }}>
                                    {{ $market->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="branch" class="form-label">Branch</label>
                        <select name="branch_id" id="branch" class="form-select">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Market</th>
                            <th>Branch</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($offers as $offer)
                        <tr>
                            <td class="text-center">
                                @if($offer->image)
                                <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}" class="offer-image">
                                @else
                                <div class="text-muted">No Image</div>
                                @endif
                            </td>
                            <td>{{ $offer->title }}</td>
                            <td>{{ $offer->branch->market->name }}</td>
                            <td>{{ $offer->branch->name }}</td>
                            <td>{{ number_format($offer->price, 2) }} AED</td>
                            <td>
                                <span class="badge bg-{{ $offer->is_active ? 'success' : 'danger' }}">
                                    {{ $offer->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action buttons">
                                    <a href="{{ route('admin.offers.edit', $offer->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit Offer">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this offer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete Offer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No offers found.
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
                {{ $offers->links('vendor.pagination.bootstrap-5') }}
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

    // Dynamic branch loading based on market selection
    const marketSelect = document.getElementById('market');
    const branchSelect = document.getElementById('branch');

    if (marketSelect && branchSelect) {
        marketSelect.addEventListener('change', function() {
            const marketId = this.value;
            branchSelect.innerHTML = '<option value="">All Branches</option>';

            if (marketId) {
                fetch(`/admin/markets/${marketId}/branches`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(branch => {
                            const option = document.createElement('option');
                            option.value = branch.id;
                            option.textContent = branch.name;
                            branchSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    }
});
</script>
@endsection 