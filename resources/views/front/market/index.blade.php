@extends('layouts.public')

@section('title', 'Markets')

@section('styles')
<style>
    .market-card {
        transition: transform 0.2s ease-in-out;
        height: 100%;
    }
    
    .market-card:hover {
        transform: translateY(-5px);
    }

    .market-logo {
        height: 120px;
        object-fit: contain;
        padding: 1rem;
    }

    .filter-section {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
    }

    .filter-section .form-check {
        padding: 0.3rem 0;
    }

    .filter-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #0d6efd;
    }

    .clear-filter {
        font-size: 0.8rem;
        color: #dc3545;
        cursor: pointer;
    }

    .clear-filter:hover {
        text-decoration: underline;
    }

    .search-box {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .search-box .form-control {
        padding-left: 2.5rem;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .sort-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .market-stats {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .market-stats i {
        margin-right: 0.3rem;
    }

    .badge-location {
        background-color: #e9ecef;
        color: #495057;
        font-weight: normal;
        font-size: 0.8rem;
    }

    .hover-primary:hover {
        color: #0d6efd !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <form id="filter-form" action="{{ route('front.market.index') }}" method="GET">
                <div class="sticky-top" style="top: 2rem;">
                    <!-- Search Box -->
                    <div class="search-box filter-section">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Search markets..." value="{{ request('search') }}">
                    </div>

                    <!-- Emirates Filter -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="filter-title mb-3">Emirates</h5>
                            <span class="clear-filter" data-filter="emirate">Clear</span>
                        </div>
                        @foreach($emirates as $emirate)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   value="{{ $emirate->id }}" 
                                   id="emirate-{{ $emirate->id }}"
                                   name="emirate[]"
                                   {{ in_array($emirate->id, (array)request('emirate', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="emirate-{{ $emirate->id }}">
                                {{ $emirate->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Districts Filter -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="filter-title mb-3">Districts</h5>
                            <span class="clear-filter" data-filter="district">Clear</span>
                        </div>
                        @foreach($districts as $district)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   value="{{ $district->id }}" 
                                   id="district-{{ $district->id }}"
                                   name="district[]"
                                   {{ in_array($district->id, (array)request('district', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="district-{{ $district->id }}">
                                {{ $district->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Categories Filter -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="filter-title mb-3">Categories</h5>
                            <span class="clear-filter">Clear</span>
                        </div>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   value="{{ $category->id }}" 
                                   id="category-{{ $category->id }}"
                                   name="category[]"
                                   {{ in_array($category->id, request()->get('category', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-{{ $category->id }}">
                                @if($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @endif
                                {{ $category->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <!-- Market List -->
        <div class="col-lg-9">
            <!-- Sort Section -->
            <div class="sort-section d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Showing {{ $markets->firstItem() ?? 0 }}-{{ $markets->lastItem() ?? 0 }} of {{ $markets->total() ?? 0 }} markets</span>
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2">Sort by:</label>
                    <select class="form-select form-select-sm sort-select" name="sort" style="width: 150px;">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name Z-A</option>
                        <option value="offers" {{ request('sort') == 'offers' ? 'selected' : '' }}>Most Offers</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>
            </div>

            <!-- Market Grid -->
            <div class="row g-4">
                @forelse($markets as $market)
                <div class="col-md-4">
                    <div class="card market-card">
                        <img src="{{ $market->logo ? asset('storage/' . $market->logo) : 'https://via.placeholder.com/200' }}" 
                             class="card-img-top market-logo" 
                             alt="{{ $market->name }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('front.market.show', $market) }}" 
                                   class="text-decoration-none text-dark hover-primary">
                                    {{ $market->name }}
                                </a>
                            </h5>
                            <div class="market-stats mb-2">
                                <span class="me-3">
                                    <i class="fas fa-tag"></i> {{ $market->active_offers_count ?? 0 }} Active Offers
                                </span>
                                <span>
                                    <i class="fas fa-store"></i> {{ $market->branches_count ?? 0 }} Branches
                                </span>
                            </div>
                            <div class="mb-3">
                                @if($market->emirates_list)
                                    @foreach(explode(', ', $market->emirates_list) as $emirate)
                                        @if(!empty($emirate))
                                            <span class="badge badge-location me-1">{{ $emirate }}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No markets found matching your criteria.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $markets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle filter form submission
    const filterForm = document.getElementById('filter-form');
    const filterInputs = filterForm.querySelectorAll('input[type="checkbox"], select');
    const searchInput = document.querySelector('.search-box input');
    let searchTimeout;

    function submitForm() {
        filterForm.submit();
    }

    // Handle checkbox changes
    filterInputs.forEach(input => {
        input.addEventListener('change', submitForm);
    });

    // Handle search with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(submitForm, 500);
    });

    // Handle clear filters
    document.querySelectorAll('.clear-filter').forEach(button => {
        button.addEventListener('click', function() {
            const filterName = this.dataset.filter;
            filterForm.querySelectorAll(`input[name^="${filterName}"]`).forEach(input => {
                input.checked = false;
            });
            submitForm();
        });
    });

    // Handle sort change
    document.querySelector('.sort-select').addEventListener('change', submitForm);
});
</script>
@endsection