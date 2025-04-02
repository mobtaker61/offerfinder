@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filters</h5>
                    
                    <form id="filterForm" action="{{ route('coupons.index') }}" method="GET">
                        <!-- Market Filter -->
                        <div class="mb-4">
                            <label class="form-label">Market</label>
                            <select name="market_id" id="marketSelect" class="form-select">
                                <option value="all">All Markets</option>
                                @foreach($markets as $market)
                                    <option value="{{ $market->id }}" {{ request('market_id') == $market->id ? 'selected' : '' }}>
                                        {{ $market->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Branch Filter -->
                        <div class="mb-4">
                            <label class="form-label">Branch</label>
                            <select name="branch_id" id="branchSelect" class="form-select" {{ !request('market_id') || request('market_id') == 'all' ? 'disabled' : '' }}>
                                <option value="all">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        <a href="{{ route('front.branch.show', $branch) }}" class="text-decoration-none">
                                            {{ $branch->name }}
                                        </a>
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-4">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="expiring" {{ request('sort') == 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                            </select>
                        </div>

                        <!-- Page Size -->
                        <div class="mb-4">
                            <label class="form-label">Items per Page</label>
                            <select name="per_page" class="form-select" onchange="this.form.submit()">
                                <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                                <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                                <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                                <option value="96" {{ request('per_page') == 96 ? 'selected' : '' }}>96</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Coupons Grid -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">All Coupons</h2>
                <div class="text-muted">
                    Showing {{ $coupons->firstItem() ?? 0 }}-{{ $coupons->lastItem() ?? 0 }} of {{ $coupons->total() }} coupons
                </div>
            </div>

            @if($coupons->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted">No coupons found matching your criteria.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($coupons as $coupon)
                        <div class="col-md-6 col-lg-4">
                            <x-coupon-card :coupon="$coupon" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $coupons->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border: none;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        color: #0d6efd;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const marketSelect = document.getElementById('marketSelect');
    const branchSelect = document.getElementById('branchSelect');
    const filterForm = document.getElementById('filterForm');
    
    if (marketSelect && branchSelect && filterForm) {
        // Function to submit the form
        const submitForm = () => {
            filterForm.submit();
        };

        // Handle market change
        marketSelect.addEventListener('change', function() {
            const marketId = this.value;
            
            // Reset and disable branch select if no market is selected
            if (marketId === 'all') {
                branchSelect.innerHTML = '<option value="all">All Branches</option>';
                branchSelect.disabled = true;
                submitForm();
                return;
            }
            
            // Enable branch select and fetch branches
            branchSelect.disabled = false;
            
            // Show loading state
            branchSelect.innerHTML = '<option value="">Loading branches...</option>';
            
            // Fetch branches for selected market
            fetch(`{{ route('coupons.branches') }}?market_id=${marketId}`)
                .then(response => response.json())
                .then(branches => {
                    branchSelect.innerHTML = '<option value="all">All Branches</option>';
                    branches.forEach(branch => {
                        const option = new Option(branch.name, branch.id);
                        branchSelect.add(option);
                    });
                    submitForm();
                })
                .catch(error => {
                    console.error('Error fetching branches:', error);
                    branchSelect.innerHTML = '<option value="all">All Branches</option>';
                    submitForm();
                });
        });

        // Handle branch change
        branchSelect.addEventListener('change', function() {
            submitForm();
        });
    }
});
</script>
@endsection 