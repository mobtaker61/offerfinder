@extends('layouts.public')

@section('title', $market->name)

@section('styles')
<style>
    .market-header {
        background: #fff;
        border-radius: 15px;
        margin-bottom: 2rem;
    }

    .market-logo {
        max-width: 200px;
        height: auto;
        margin-bottom: 1rem;
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

    .market-stats .stat-item {
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

    .app-links .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }

    .app-links svg {
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Market Header Section -->
    <div class="market-header">
        <div class="row g-4">
            <!-- Info Section (col-8) -->
            <div class="col-md-7">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ $market->logo ? asset('storage/' . $market->logo) : 'https://placehold.co/200x200?text=Market' }}"
                                    alt="{{ $market->name }}"
                                    class="market-logo img-fluid rounded">
                            </div>
                            <div class="col-8">
                                <h4 class="card-title mb-1">{{ $market->name }}</h4>
                                @if($market->local_name)
                                <h6 class="text-muted mb-3">{{ $market->local_name }}</h6>
                                @endif

                                @if($market->description)
                                <div class="mb-3">
                                    <p class="text-muted">{{ $market->description }}</p>
                                </div>
                                @endif

                                <div class="market-stats">
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <div class="stat-item">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                <span>{{ $stats['emirates_count'] }} Emirates</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat-item">
                                                <i class="fas fa-store me-2"></i>
                                                <span>{{ $stats['total_branches'] }} Branches</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat-item">
                                                <i class="fas fa-tag me-2"></i>
                                                <span>{{ $stats['active_offers'] }} Active Offers</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section (col-4) -->
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-body">
                        @if($market->email)
                        <div class="contact-item mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:{{ $market->email }}" class="text-decoration-none">
                                {{ $market->email }}
                            </a>
                        </div>
                        @endif

                        @if($market->phone)
                        <div class="contact-item mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:{{ $market->phone }}" class="text-decoration-none">
                                {{ $market->phone }}
                            </a>
                        </div>
                        @endif

                        @if($market->website)
                        <div class="contact-item mb-2">
                            <i class="fas fa-globe me-2"></i>
                            <a href="{{ $market->website }}" target="_blank" class="text-decoration-none">
                                Visit Website
                            </a>
                        </div>
                        @endif

                        <div class="mt-4">
                            <h6 class="mb-2">Social Media</h6>
                            <div class="social-links mb-3">
                                @if($market->facebook)
                                <a href="{{ $market->facebook }}" target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                @endif

                                @if($market->instagram)
                                <a href="https://instagram.com/{{ ltrim($market->instagram, '@') }}" target="_blank" class="btn btn-outline-danger btn-sm me-2">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif

                                @if($market->twitter)
                                <a href="https://twitter.com/{{ ltrim($market->twitter, '@') }}" target="_blank" class="btn btn-outline-info btn-sm me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif

                                @if($market->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $market->whatsapp) }}" target="_blank" class="btn btn-outline-success btn-sm me-2">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @endif
                            </div>

                            <h6 class="mb-2">Mobile Apps</h6>
                            <div class="app-links">
                                @if($market->ios_app_link)
                                <a href="{{ $market->ios_app_link }}" target="_blank" class="btn btn-outline-dark btn-sm me-2">
                                    <svg viewBox="0 0 24 24" width="18" height="18" class="me-1">
                                        <path fill="currentColor" d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                                    </svg>
                                    App Store
                                </a>
                                @endif

                                @if($market->android_app_link)
                                <a href="{{ $market->android_app_link }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                    <svg viewBox="0 0 24 24" width="18" height="18" class="me-1">
                                        <path fill="currentColor" d="M16.61 15.15c-.46 0-.84-.37-.84-.83s.37-.84.84-.84c.46 0 .84.37.84.84s-.37.83-.84.83m-9.2 0c-.46 0-.84-.37-.84-.83s.37-.84.84-.84c.46 0 .84.37.84.84s-.37.83-.84.83m9.5-4.27L19 9.12l1.24-1.24c.31-.31.31-.82 0-1.13-.31-.31-.82-.31-1.13 0l-1.48 1.48C16.51 7.45 15.05 7 13.5 7s-3.01.45-4.13 1.23L7.89 6.75c-.31-.31-.82-.31-1.13 0-.31.31-.31.82 0 1.13L8 9.12l2.09 1.76c-1.02 1.58-1.13 3.58-.33 5.26.95 2 2.95 3.36 5.24 3.36s4.29-1.36 5.24-3.36c.8-1.68.69-3.68-.33-5.26M7 15.15c0 .55-.45 1-1 1s-1-.45-1-1v-4c0-.55.45-1 1-1s1 .45 1 1v4m12 0c0 .55-.45 1-1 1s-1-.45-1-1v-4c0-.55.45-1 1-1s1 .45 1 1v4" />
                                    </svg>
                                    Play Store
                                </a>
                                @endif
                            </div>
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
        <ul class="nav nav-pills mb-4" id="offersTab" role="tablist">
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
                <div class="row row-cols-6 g-4">
                    @forelse($activeOffers as $offer)
                    <div class="col">
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
                <div class="row row-cols-6 g-4">
                    @forelse($upcomingOffers as $offer)
                    <div class="col">
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
                <div class="row row-cols-6 g-4">
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