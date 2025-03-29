@extends('layouts.public')

@section('content')
<section id="billboard" style="margin-top: -200px;">
    <div style="background-image: url(images/background-big.png);background-repeat: no-repeat; width: 100%;">
        <div class="container d-flex position-relative">
            <div class="row flex-row-reverse align-items-center padding-medium mt-md-5">
                <div class="col-md-4 d-none d-sm-block">
                    <img src="/images/banner-illustration.png" class="img-fluid" alt="banner">
                </div>
                <div class="col-md-8 mt-5">
                    <h2 class="herotext display-4 fw-bold text-capitalize mb-4">
                        Don't miss out opportunities!
                    </h2>
                    <!-- Offer Filters -->
                    <div class="container mt-4">
                        <form id="offerFilterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="emirate_id" id="emirateFilter" class="form-control">
                                        <option value="all">All Emirates</option>
                                        @foreach ($emirates as $emirate)
                                        <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="market_id" id="marketFilter" class="form-control" disabled>
                                        <option value="all">All Markets</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="branch_id" id="branchFilter" class="form-control" disabled>
                                        <option value="all">All Branches</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="category_id" id="categoryFilter" class="form-control">
                                        <option value="all">All Categories</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @foreach ($category->children as $child)
                                        <option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;- {{ $child->name }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Offer List -->
<div class="container mt-n4" id="offerList">
    <div class="row">
        @foreach ($offers as $offer)
        <div class="col-md-3 mb-4 align-items-stretch">
            @include('components.offer-card', ['offer' => $offer])
        </div>
        @endforeach
    </div>
</div>

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
            <div class="col-md-4">
                <img src="/images/offer-vip.png" class="img-fluid" alt="banner">
            </div>
            <div class="row col-md-8">
                @foreach ($vipOffers as $offer)
                <div class="col-md-4">
                    @include('components.offer-card', ['offer' => $offer])
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Offers Section -->
<section class="upcoming-offers py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-6 fw-bold">Upcoming Offers</h2>
            <p class="text-muted">Don't miss out on these upcoming deals!</p>
        </div>
        <div class="row g-4">
            @foreach($upcomingOffers ?? [] as $offer)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ $offer->image_url }}" class="card-img-top" alt="{{ $offer->title }}">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-warning">Coming Soon</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $offer->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($offer->description, 100) }}</p>
                        <p class="mb-0"><small class="text-muted">Starts: {{ $offer->start_date->format('d M Y') }}</small></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blog-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-6 fw-bold">Latest from Our Blog</h2>
            <p class="text-muted">Stay updated with the latest news and tips</p>
        </div>
        <div class="row g-4">
            @foreach($latestPosts ?? [] as $post)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $post->image_url }}" class="card-img-top" alt="{{ $post->title }}">
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit($post->excerpt, 100) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('blog.index') }}" class="btn btn-primary">View All Posts</a>
        </div>
    </div>
</section>

<!-- Market Logo Slider -->
<section id="brand-collection" class="bg-secondary py-5">
    <h3 class="text-center mb-4">Our Markets</h3>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($markets->shuffle() as $market)
            <div class="swiper-slide">
                <a href="{{ route('front.market.show', $market) }}" class="market-avatar">
                    <img src="{{ $market->logo_url }}" alt="{{ $market->name }}" class="img-fluid rounded-circle">
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
<!-- SCRIPTS -->
<script>
    // Request FCM Token
    function requestFcmToken() {
        if (typeof firebase !== 'undefined') {
            const messaging = firebase.messaging();
            messaging.requestPermission()
                .then(() => messaging.getToken())
                .then(token => {
                    document.getElementById('fcm_token').value = token;
                })
                .catch(err => console.error('FCM token error:', err));
        }
    }
    if (typeof firebase !== 'undefined') {
        requestFcmToken();
    }

    // AJAX Newsletter Submission
    document.getElementById('newsletterForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let email = document.getElementById('newsletterEmail').value;
        let fcmToken = document.getElementById('fcm_token').value;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch("{{ route('subscribe') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    email: email,
                    fcm_token: fcmToken
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('newsletterMessage').innerHTML =
                    `<div class="alert alert-success">${data.message}</div>`;
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById('newsletterMessage').innerHTML =
                    `<div class="alert alert-danger">Subscription failed. Please try again.</div>`;
            });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 7,
            spaceBetween: 5,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        // Handle filter changes
        const filterForm = document.getElementById('offerFilterForm');
        const emirateFilter = document.getElementById('emirateFilter');
        const marketFilter = document.getElementById('marketFilter');
        const branchFilter = document.getElementById('branchFilter');
        const categoryFilter = document.getElementById('categoryFilter');
        const offerList = document.getElementById('offerList');

        function updateOffers() {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);

            fetch(`${window.location.pathname}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update the offer list
                    const offersHtml = data.offers.map(offer => {
                        return `
                        <div class="col-md-3 mb-4 align-items-stretch">
                            ${renderOfferCard(offer)}
                        </div>
                    `;
                    }).join('');

                    offerList.innerHTML = `<div class="row">${offersHtml}</div>`;
                })
                .catch(error => console.error('Error:', error));
        }

        function renderOfferCard(offer) {
            return `
                <div class="card h-100">
                    <div class="image-container">
                        <div class="first">
                            <div class="d-flex justify-content-between align-items-center">
                                ${offer.market ? `<h6 class="discount">${offer.market.name}</h6>` : ''}
                                ${offer.pdf ? `<a href="/storage/${offer.pdf}" class="wishlist" target="_blank"><i class="fa fa-pdf"></i></a>` : ''}
                            </div>
                        </div>
                        <img src="${offer.cover_image ? `/storage/${offer.cover_image}` : '/images/default-cover.jpg'}" 
                             class="img-fluid rounded thumbnail-image" 
                             alt="${offer.title}">
                    </div>
                    <div class="product-detail-container p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="offer-title">
                                <a href="/offer/${offer.id}">${offer.title}</a>
                            </h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-1">
                            <h6 class="text-muted m-0">Valid: ${new Date(offer.end_date).toLocaleDateString()}</h6>
                            <div class="d-flex">
                                <span class="buy">${calculateRemainingDays(offer.end_date)} days</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function calculateRemainingDays(endDate) {
            const end = new Date(endDate);
            const today = new Date();
            const diffTime = Math.abs(end - today);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        // Event listeners for filters
        emirateFilter.addEventListener('change', updateOffers);
        marketFilter.addEventListener('change', updateOffers);
        branchFilter.addEventListener('change', updateOffers);
        categoryFilter.addEventListener('change', updateOffers);
    });
</script>
@endsection