@extends('layouts.public')

@section('title', $market->name)

@section('styles')
<style>
    .market-header {
        background: #fff;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .market-logo {
        width: 150px;
        height: 150px;
        object-fit: contain;
    }

    .market-info {
        color: #6c757d;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #0d6efd;
    }

    .offer-card {
        transition: transform 0.2s;
    }

    .offer-card:hover {
        transform: translateY(-5px);
    }

    .offer-image {
        height: 200px;
        object-fit: cover;
    }

    .branch-card {
        height: 100%;
        transition: transform 0.2s;
    }

    .branch-card:hover {
        transform: translateY(-5px);
    }

    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }

    .status-active {
        background-color: #198754;
        color: white;
    }

    .status-upcoming {
        background-color: #0dcaf0;
        color: white;
    }

    .status-expired {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Market Header Section -->
    <div class="market-header">
        <div class="row align-items-center">
            <div class="col-md-3 text-center text-md-start">
                <img src="{{ $market->logo ? asset('storage/' . $market->logo) : 'https://via.placeholder.com/150' }}" 
                     alt="{{ $market->name }}" 
                     class="market-logo mb-3 mb-md-0">
            </div>
            <div class="col-md-9">
                <h1 class="mb-3">{{ $market->name }}</h1>
                <div class="market-info">
                    <p class="mb-2">{{ $market->description }}</p>
                    <div class="d-flex flex-wrap gap-4">
                        <div>
                            <i class="fas fa-tag me-2"></i>
                            <span>{{ $stats['active_offers'] }} Active Offers</span>
                        </div>
                        <div>
                            <i class="fas fa-store me-2"></i>
                            <span>{{ $stats['total_branches'] }} Branches</span>
                        </div>
                        <div>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>{{ $stats['emirates_count'] }} Emirates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offers Section with Tabs -->
    <section class="mb-5">
        <h2 class="section-title">Offers</h2>
        
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="offersTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" 
                        id="active-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#active" 
                        type="button" 
                        role="tab" 
                        aria-controls="active" 
                        aria-selected="true">
                    Active ({{ $stats['active_offers'] }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="upcoming-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#upcoming" 
                        type="button" 
                        role="tab" 
                        aria-controls="upcoming" 
                        aria-selected="false">
                    Upcoming ({{ $stats['upcoming_offers'] }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="finished-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#finished" 
                        type="button" 
                        role="tab" 
                        aria-controls="finished" 
                        aria-selected="false">
                    Finished ({{ $stats['finished_offers'] }})
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="offersTabContent">
            <!-- Active Offers -->
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                <div class="row g-4">
                    @forelse($activeOffers as $offer)
                        <div class="col-md-3">
                            @include('components.offer-card', ['offer' => $offer])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                No active offers available at the moment.
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($activeOffers->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $activeOffers->links() }}
                    </div>
                @endif
            </div>

            <!-- Upcoming Offers -->
            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                <div class="row g-4">
                    @forelse($upcomingOffers as $offer)
                        <div class="col-md-3">
                            @include('components.offer-card', ['offer' => $offer])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                No upcoming offers at the moment.
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($upcomingOffers->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $upcomingOffers->links() }}
                    </div>
                @endif
            </div>

            <!-- Finished Offers -->
            <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
                <div class="row g-4">
                    @forelse($finishedOffers as $offer)
                        <div class="col-md-3">
                            @include('components.offer-card', ['offer' => $offer])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                No finished offers to display.
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($finishedOffers->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $finishedOffers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Branches Section -->
    <section class="mb-5">
        <h2 class="section-title">Market Branches</h2>
        <div class="row g-4">
            @forelse($market->branches as $branch)
                <div class="col-md-4">
                    <x-branch-card :branch="$branch" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No branches available.
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tab changes
    const triggerTabList = document.querySelectorAll('#offersTab button');
    triggerTabList.forEach(triggerEl => {
        triggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            const tabId = this.getAttribute('data-bs-target').replace('#', '');
            
            // You can add AJAX loading here if needed
            // loadOffers(tabId);
        });
    });

    // Function to load offers via AJAX if needed
    function loadOffers(status) {
        fetch(`/market/{{ $market->id }}/offers?status=${status}`)
            .then(response => response.json())
            .then(data => {
                // Update the content
                document.querySelector(`#${status}`).innerHTML = data.html;
                // Update pagination
                document.querySelector(`#${status} .pagination-container`).innerHTML = data.pagination;
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>
@endpush
@endsection 