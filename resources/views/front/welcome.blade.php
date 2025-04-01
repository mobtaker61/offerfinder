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
                                <div class="col-md-4">
                                    <select name="emirate_id" id="emirateFilter" class="form-control">
                                        <option value="all">All Emirates</option>
                                        @foreach ($emirates as $emirate)
                                        <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="market_id" id="marketFilter" class="form-control" disabled>
                                        <option value="all">Select Market</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="branch_id" id="branchFilter" class="form-control" disabled>
                                        <option value="all">Select Branch</option>
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
    <div class="row row-cols-xs-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 mb-4">
        @foreach ($offers as $offer)
        <div class="col align-items-stretch mb-4" style="height: 330px;">
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
        <div class="row row-cols-xs-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 mb-4">
            @foreach ($upcomingOffers as $offer)
            <div class="col align-items-stretch mb-4" style="height: 330px;">
                @include('components.offer-card', ['offer' => $offer])
            </div>
            @endforeach
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
        <div class="row g-4">
            @foreach($latestPosts ?? [] as $post)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $post->image_url }}" class="card-img-top" alt="{{ $post->title }}">
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                        <a href="{{ route('blog.show', $post->slug) }}">
                            <h5 class="card-title">{{ $post->title }}</h5>
                        </a>
                        <p class="card-text">{{ Str::limit($post->excerpt, 100) }}</p>
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
<section id="brand-collection" class="bg-primary py-5">
    <h3 class="text-center mb-4 text-white">Markets</h3>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($markets->shuffle() as $market)
            <div class="swiper-slide text-center">
                <a href="{{ route('front.market.show', $market) }}">
                    <img src="{{ asset('storage/' . $market->avatar) }}" alt="{{ $market->name }}" class=" rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
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
                        <div class="col align-items-stretch mb-4" style="height: 330px;">
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
                        </div>
                    `;
                    }).join('');

                    offerList.innerHTML = `<div class="row row-cols-xs-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 mb-4">${offersHtml}</div>`;
                })
                .catch(error => console.error('Error:', error));
        }

        function calculateRemainingDays(endDate) {
            const end = new Date(endDate);
            const today = new Date();
            const diffTime = Math.abs(end - today);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        // Event listeners for filters
        emirateFilter.addEventListener('change', function() {
            const emirateId = this.value;
            
            // Reset and disable market and branch filters
            marketFilter.innerHTML = '<option value="all">Select Market</option>';
            marketFilter.disabled = true;
            branchFilter.innerHTML = '<option value="all">Select Branch</option>';
            branchFilter.disabled = true;

            if (emirateId === 'all') {
                updateOffers();
                return;
            }

            // Update markets based on emirate
            fetch(`/get-markets-by-emirate?emirate_id=${emirateId}`)
            .then(response => response.json())
            .then(data => {
                    marketFilter.innerHTML = '<option value="all">Select Market</option>';
                    data.markets.forEach(market => {
                        marketFilter.innerHTML += `<option value="${market.id}">${market.name}</option>`;
                    });
                    marketFilter.disabled = false;
                    updateOffers();
                });
        });

        marketFilter.addEventListener('change', function() {
            const marketId = this.value;
            const emirateId = emirateFilter.value;
            
            // Reset and disable branch filter
            branchFilter.innerHTML = '<option value="all">Select Branch</option>';
            branchFilter.disabled = true;

            if (marketId === 'all') {
                updateOffers();
                return;
            }

            // Update branches based on market and emirate
            fetch(`/get-branches-by-market-and-emirate/${marketId}/${emirateId}`)
                .then(response => response.json())
                .then(data => {
                    branchFilter.innerHTML = '<option value="all">Select Branch</option>';
                    data.forEach(branch => {
                        branchFilter.innerHTML += `<option value="${branch.id}">${branch.name}</option>`;
                    });
                    branchFilter.disabled = false;
                    updateOffers();
                });
        });

        branchFilter.addEventListener('change', updateOffers);
    });
</script>
@endsection