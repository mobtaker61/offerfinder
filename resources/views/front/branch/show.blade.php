@extends('layouts.public')

@section('title', $branch->name)

@section('styles')
<style>
    .branch-header {
        background: #fff;
        border-radius: 15px;
        margin-bottom: 2rem;
    }

    .branch-info {
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

    .branch-stats .stat-item {
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .contact-item {
        color: #6c757d;
    }

    .contact-item a {
        color: inherit;
    }

    .contact-item a:hover {
        color: #0d6efd;
    }

    .social-links .btn {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .social-links .btn i {
        font-size: 1.1rem;
    }

    .map-container {
        height: 300px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Branch Header Section -->
    <div class="branch-header">
        <div class="row g-4">
            <!-- Info Section -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body row">
                        <div class="col-md-2">
                            <img src="{{ $branch->market->avatar ? asset('storage/' . $branch->market->avatar) : 'https://placehold.co/200x200?text=Market' }}"
                                alt="{{ $branch->market->name }}"
                                class="market-avatar">
                        </div>
                        <div class="col-md-10">
                            <h4 class="card-title mb-1">{{ $branch->name }}</h4>
                            <h6 class="text-muted mb-0">
                                <a href="{{ route('front.market.show', $branch->market) }}" class="text-decoration-none">
                                    {{ $branch->market->name }}
                                </a>
                            </h6>
                        </div>

                        @if($branch->description)
                        <div class="mb-3">
                            <p class="text-muted">{{ $branch->description }}</p>
                        </div>
                        @endif

                        <div class="branch-stats">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="stat-item">
                                        <i class="fas fa-clock me-2"></i>
                                        <span>{{ $branch->working_hours ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="stat-item">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <span>
                                            @if($branch->neighbours->isNotEmpty())
                                            @php
                                            $neighbour = $branch->neighbours->first();
                                            $district = $neighbour->district;
                                            $emirate = $district->emirate;
                                            @endphp
                                            {{ $emirate->name }} > {{ $district->name }} > {{ $neighbour->name }}
                                            @else
                                            N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="stat-item">
                                        <i class="fas fa-tag me-2"></i>
                                        <span>{{ $stats['active_offers'] }} Active Offers</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="stat-item">
                                        <i class="fas fa-tag me-2"></i>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $branchActiveCoupons }} Branch + {{ $marketActiveCoupons }} Market">{{ $stats['active_coupons'] }} Active Coupons</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body branch-stats">
                        <h5 class="card-title mb-4">Contact Information</h5>
                        @if($branch->address)
                        <div class="contact-item mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>{{ $branch->address }}</span>
                        </div>
                        @endif

                        @if($branch->contactProfiles->isNotEmpty())
                        @foreach($branch->contactProfiles as $contact)
                        @switch($contact->type)
                        @case('whatsapp')
                        <div class="stat-item">
                            <i class="fab fa-whatsapp"></i>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->value) }}"
                                target="_blank"
                                title="WhatsApp">
                                <span class="text-muted">{{ $contact->value }}</span>
                            </a>
                        </div>
                        @break
                        @case('phone')
                        <div class="stat-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:{{ $contact->value }}"
                                title="Call">
                                <span class="text-muted">{{ $contact->value }}</span>
                            </a>
                        </div>
                        @break
                        @case('email')
                        <div class="stat-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ $contact->value }}"
                                title="Email">
                                <span class="text-muted">{{ $contact->value }}</span>
                            </a>
                        </div>
                        @break
                        @case('instagram')
                        <div class="stat-item">
                            <i class="fab fa-instagram"></i>
                            <a href="https://instagram.com/{{ ltrim($contact->value, '@') }}"
                                target="_blank"
                                title="Instagram">
                                <span class="text-muted">{{ $contact->value }}</span>
                            </a>
                        </div>
                        @break
                        @case('facebook')
                        <div class="stat-item">
                            <i class="fab fa-facebook"></i>
                            <a href="{{ $contact->value }}"
                                target="_blank"
                                title="Facebook">
                                <span class="text-muted">{{ $contact->value }}</span>
                            </a>
                        </div>
                        @break
                        @case('twitter')
                        <div class="stat-item">
                            <i class="fab fa-twitter"></i>
                            <a href="https://twitter.com/{{ ltrim($contact->value, '@') }}"
                                target="_blank"
                                title="Twitter">
                                <span class="text-muted">{{ $contact->value }}</span>
                            </a>
                        </div>
                        @break
                        @endswitch
                        @endforeach
                        @else
                        <div class="alert alert-info">
                            No contact information available.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body p-0">
                        @if($branch->latitude && $branch->longitude)
                        <div class="map-container m-0">
                            <iframe
                                width="100%"
                                height="100%"
                                frameborder="0"
                                scrolling="no"
                                marginheight="0"
                                marginwidth="0"
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $branch->longitude - 0.01 }},{{ $branch->latitude - 0.01 }},{{ $branch->longitude + 0.01 }},{{ $branch->latitude + 0.01 }}&layer=mapnik&marker={{ $branch->latitude }},{{ $branch->longitude }}">
                            </iframe>
                        </div>
                        @else
                        <div class="alert alert-info">
                            No location coordinates available.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offers Section -->
    <section class="mb-5">
        <h2 class="section-title">Branch Offers</h2>
        <ul class="nav nav-tabs" id="offersTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="true">
                    Active Offers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="false">
                    Upcoming Offers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="finished-tab" data-bs-toggle="tab" data-bs-target="#finished" type="button" role="tab" aria-controls="finished" aria-selected="false">
                    Finished Offers
                </button>
            </li>
        </ul>

        <div class="tab-content" id="offersTabContent">
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                <div class="row row-cols-2 row-cols-md-6 g-4">
                    @forelse($activeOffers as $offer)
                    <div class="col">
                        @include('components.offer-card', ['offer' => $offer])
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No active offers to display.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                <div class="row row-cols-2 row-cols-md-6 g-4">
                    @forelse($upcomingOffers as $offer)
                    <div class="col">
                        @include('components.offer-card', ['offer' => $offer])
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No upcoming offers to display.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
                <div class="row row-cols-2 row-cols-md-6 g-4">
                    @forelse($finishedOffers as $offer)
                    <div class="col">
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
            </div>
        </div>
    </section>

    <!-- Branch Coupons Section -->
    <div class="section mb-5">
        <div class="section-title mb-4">
            <h3>Branch Coupons</h3>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($branch->coupons()->where('start_date', '<=', now())->where('end_date', '>=', now())->get() as $coupon)
                <div class="col">
                    <x-coupon-card :coupon="$coupon" />
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No active coupons available for this branch.
                    </div>
                </div>
                @endforelse
        </div>
    </div>

    <!-- Market Coupons Section -->
    <div class="section mb-5">
        <div class="section-title mb-4">
            <h3>Market Coupons</h3>
            <small class="text-muted">Available at all {{ $branch->market->name }} branches</small>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($branch->market->coupons()->where('start_date', '<=', now())->where('end_date', '>=', now())->get() as $coupon)
                <div class="col">
                    <x-coupon-card :coupon="$coupon" />
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No active coupons available for this market.
                    </div>
                </div>
                @endforelse
        </div>
    </div>

    <!-- Latest News Section -->
    <section class="mb-5">
        <h2 class="section-title">Latest News</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($branch->market->posts()->latest()->take(3)->get() as $post)
            <div class="col">
                <x-blog-post-card :post="$post" />
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No news available at the moment.
                </div>
            </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

@section('scripts')
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
            fetch(`/branch/{{ $branch->id }}/offers?status=${status}`)
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
@endsection