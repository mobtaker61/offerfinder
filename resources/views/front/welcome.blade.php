@extends('layouts.public')

@section('content')
<section id="billboard" style="margin-top: -150px;">
    <div style="background-image: url(images/background-big.png);background-repeat: no-repeat; width: 100%;background-size: cover;">
        <div class="container">
            <div class="row align-items-center padding-medium mt-md-5">
                <div class="col-md-10 mt-5">
                    <h2 class="herotext display-4 fw-bold text-capitalize mb-4">
                        Don't miss out opportunities!
                    </h2>
                    <!-- Offer Filters -->
                    <div class="container mt-4">
                        <form id="offerFilterForm">
                            <div class="row row-cols-3">
                                <div class="col">
                                    <select name="emirate_id" id="emirateFilter" class="form-control">
                                        <option value="all">All Emirates</option>
                                        @foreach ($emirates as $emirate)
                                        <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="market_id" id="marketFilter" class="form-control" disabled>
                                        <option value="all">Select Market</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="branch_id" id="branchFilter" class="form-control" disabled>
                                        <option value="all">Select Branch</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 d-none d-sm-block">
                    <img src="/images/banner-illustration.png" class="img-fluid" alt="banner" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Offer List -->
<div class="container mt-n2" id="offerList">
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 mb-4">
        @foreach ($offers as $offer)
        <div class="col align-items-stretch mb-4">
            @include('components.offer-card', ['offer' => $offer])
        </div>
        @endforeach
    </div>
</div>

<!-- Active Coupons Section -->
<section class="active-coupons-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="section-title text-center">Active Coupons</h2>
            <a href="{{ route('coupons.index') }}" class="btn btn-outline-primary">View All</a>
        </div>
        <div class="coupons-scroll-container">
            <div class="coupons-scroll-wrapper">
                @forelse($activeCoupons as $coupon)
                <div class="coupon-scroll-item">
                    <x-coupon-card :coupon="$coupon" />
                </div>
                @empty
                <div class="text-center py-5">
                    <p class="text-muted">No active coupons available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Exclusive Offer -->
<section id="Exclusive" class="mb-4">
    <div class="position-relative z-n1">
        <div class="position-absolute">
            <h2 class="sectiontext display-4 text-uppercase">EXCLUSIVE</h2>
        </div>
    </div>
    <div class="container text-center">
        <div>
            <h3 class="fw-bolder text-center mb-5">
                Exclusive Offers
            </h3>
        </div>
        <div class="row">
            <div class="col-md-2 d-none d-md-block">
                <img src="/images/offer-vip.png" class="img-fluid" alt="banner">
            </div>
            <div class="col-md-10">
                <div class="vip-offers-scroll-container">
                    <div class="vip-offers-scroll-wrapper">
                        @foreach ($vipOffers as $offer)
                        <div class="vip-offer-scroll-item">
                            @include('components.offer-card', ['offer' => $offer])
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Offers Section -->
<section class="upcoming-offers py-3 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-6 fw-bold">Upcoming Offers</h2>
            <p class="text-muted">Don't miss out on these upcoming deals!</p>
        </div>
        <div class="upcoming-offers-scroll-container">
            <div class="upcoming-offers-scroll-wrapper">
                @foreach ($upcomingOffers as $offer)
                <div class="">
                    @include('components.offer-card', ['offer' => $offer])
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blog-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-6 fw-bold">Latest News</h2>
            <p class="text-muted">Stay updated with the latest news and tips</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($latestPosts ?? [] as $post)
            <div class="col">
                <x-blog-post-card :post="$post" />
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('blog.index') }}" class="btn btn-primary">View All Posts</a>
        </div>
    </div>
</section>

<!-- Market Logo Slider -->
<section id="brand-collection" class="bg-primary py-3">
    <div class="market-logos-container">
        <div class="market-logos-scroll">
            @foreach ($markets->shuffle()->take(20) as $market)
            <div class="market-logo">
                <a href="{{ route('front.market.show', $market) }}">
                    <img src="{{ asset('storage/' . $market->avatar) }}" alt="{{ $market->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter Subscription -->
<div id="newsletter" class="bg-light py-4">
    <div class="container text-center ">
        <form id="newsletterForm" class="d-flex justify-content-center mt-3">
            <h3>Our Newsletter</h3>
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" id="newsletterEmail" class="form-control"
                    placeholder="Enter your email" aria-label="user email address" aria-describedby="button-addon2"
                    required>
                <input type="hidden" id="fcm_token" name="fcm_token">
                <button class="btn btn-primary" type="submit" id="button-addon2">Subscribe</button>
            </div>
        </form>
        <div id="newsletterMessage"></div> <!-- Show messages here -->
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Remove all conflicting event handlers
    window.onbeforeunload = null;

    // Function to update offers based on filters
    function updateOffers() {
        const emirateId = document.getElementById('emirate_id').value;
        const marketId = document.getElementById('market_id').value;
        const branchId = document.getElementById('branch_id').value;

        // Show loading state
        const offersContainer = document.getElementById('offers-container');
        offersContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        // Make the request
        fetch(`/offers/filter?emirate_id=${emirateId}&market_id=${marketId}&branch_id=${branchId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.html) {
                    offersContainer.innerHTML = data.html;
                } else {
                    throw new Error('Invalid response format');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                offersContainer.innerHTML = '<div class="alert alert-danger">Error loading offers. Please try again.</div>';
            });
    }

    // Handle form submission
    document.getElementById('offerFilterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateOffers();
    });

    // Handle offer card clicks
    document.querySelectorAll('.offer-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // If clicking on the share button, don't navigate
            if (e.target.closest('.wishlist')) {
                return;
            }

            // Get the offer URL from the link
            const link = this.querySelector('a');
            if (link) {
                window.location.href = link.href;
            }
        });
    });

    // Handle filter changes
    document.addEventListener('DOMContentLoaded', function() {
        const emirateFilter = document.getElementById('emirateFilter');
        const marketFilter = document.getElementById('marketFilter');
        const branchFilter = document.getElementById('branchFilter');

        if (emirateFilter) {
            emirateFilter.addEventListener('change', function(e) {
                e.preventDefault();
                updateOffers();
            });
        }

        if (marketFilter) {
            marketFilter.addEventListener('change', function(e) {
                e.preventDefault();
                updateOffers();
            });
        }

        if (branchFilter) {
            branchFilter.addEventListener('change', function(e) {
                e.preventDefault();
                updateOffers();
            });
        }
    });
</script>
@endsection

@section('styles')
<style>
    .active-coupons {
        background-color: #f8f9fa;
    }

    /* Market logos styles */
    .market-logos-container {
        width: 100%;
        overflow: hidden;
        position: relative;
        padding: 0 20px;
    }

    .market-logos-scroll {
        display: flex;
        overflow-x: auto;
        padding: 10px 0;
        gap: 20px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .market-logos-scroll::-webkit-scrollbar {
        display: none;
    }

    .market-logo {
        flex: 0 0 auto;
        text-align: center;
    }

    .market-logo img {
        transition: transform 0.3s ease;
    }

    .market-logo img:hover {
        transform: scale(1.1);
    }

    /* Active Coupons Section Styles */
    .active-coupons-section {
        background-color: #f8f9fa;
    }

    .coupons-scroll-container {
        position: relative;
        width: 100%;
        overflow-x: auto;
        padding: 1rem 0;
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .coupons-scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .coupons-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .coupons-scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .coupons-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .coupons-scroll-wrapper {
        display: flex;
        gap: 1rem;
        padding: 0.5rem;
    }

    .coupon-scroll-item {
        flex: 0 0 300px;
        min-width: 300px;
    }

    @media (max-width: 768px) {
        .coupon-scroll-item {
            flex: 0 0 250px;
            min-width: 250px;
        }
    }

    /* VIP Offers Section Styles */
    .vip-offers-scroll-container {
        position: relative;
        width: 100%;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .vip-offers-scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .vip-offers-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .vip-offers-scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .vip-offers-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .vip-offers-scroll-wrapper {
        display: flex;
        gap: 1rem;
    }

    .vip-offer-scroll-item {
        flex: 0 0 200px;
        min-width: 200px;
    }

    @media (max-width: 768px) {
        .vip-offer-scroll-item {
            flex: 0 0 180px;
            min-width: 180px;
        }
    }

    /* Upcoming Offers Section Styles */
    .upcoming-offers-scroll-container {
        position: relative;
        width: 100%;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .upcoming-offers-scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .upcoming-offers-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .upcoming-offers-scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .upcoming-offers-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .upcoming-offers-scroll-wrapper {
        display: flex;
        gap: 1rem;
    }

    .upcoming-offer-scroll-item {
        flex: 0 0 250px;
        min-width: 250px;
        height: 330px;
    }

    @media (max-width: 768px) {
        .upcoming-offer-scroll-item {
            flex: 0 0 220px;
            min-width: 220px;
        }
    }
</style>
@endsection