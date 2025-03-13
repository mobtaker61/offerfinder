@extends('layouts.public')

@section('content')
    <section id="billboard" style="margin-top: -200px;">
        <div style="background-image: url(images/background-big.png);background-repeat: no-repeat; width: 100%;">
            <div class="container d-flex position-relative">
                <div class="row flex-row-reverse align-items-center padding-medium mt-md-5">
                    <div class="col-md-4">
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
                                            <option value="all">All Markets</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="branch_id" id="branchFilter" class="form-control" disabled>
                                            <option value="all">All Branches</option>
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

    <!-- Market Logo Slider -->
    <section id="brand-collection" class="bg-secondary py-5">
        <h3 class="text-center mb-4">Our Markets</h3>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($markets->shuffle() as $market)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $market->logo) }}" class="img-fluid" alt="{{ $market->name }}" height="75">
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
                slidesPerView: 5,
                spaceBetween: 20,
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

            let emirateFilter = document.getElementById('emirateFilter');
            let marketFilter = document.getElementById('marketFilter');
            let branchFilter = document.getElementById('branchFilter');

            emirateFilter.addEventListener('change', function() {
                let emirateId = this.value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('home') }}?emirate_id=" + emirateId, {
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateOfferList(data.offers);
                        populateMarkets(data.markets);
                        populateBranches([]);
                        marketFilter.disabled = false;
                    })
                    .catch(error => console.error("Error:", error));
            });

            marketFilter.addEventListener('change', function() {
                let marketId = this.value;
                let emirateId = emirateFilter.value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('getBranchesByMarketAndEmirate') }}?market_id=" + marketId +
                        "&emirate_id=" + emirateId, {
                            method: "GET",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                    .then(response => response.json())
                    .then(data => {
                        populateBranches(data.branches);
                        updateOfferList(data.offers);
                        branchFilter.disabled = data.branches.length === 0;
                    })
                    .catch(error => console.error("Error:", error));
            });

            branchFilter.addEventListener('change', function() {
                let branchId = this.value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('getOffersByBranch') }}?branch_id=" + branchId, {
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateOfferList(data.offers);
                    })
                    .catch(error => console.error("Error:", error));
            });

            function updateOfferList(offers) {
                let offerList = document.getElementById('offerList').querySelector('.row');
                offerList.innerHTML = '';
                if (offers.length > 0) {
                    offers.forEach(offer => {
                        fetch(`{{ url('offer/card') }}/${offer.id}`)
                            .then(response => response.text())
                            .then(html => {
                                offerList.innerHTML +=
                                    `<div class="col-md-3 mb-4 align-items-stretch">${html}</div>`;
                            })
                            .catch(error => console.error("Error:", error));
                    });
                } else {
                    offerList.innerHTML = '<div class="col-12"><p>No offers available.</p></div>';
                }
            }

            function populateMarkets(markets) {
                marketFilter.innerHTML = '<option value="all">All Markets</option>';
                markets.forEach(market => {
                    marketFilter.innerHTML += `<option value="${market.id}">${market.name}</option>`;
                });
            }

            function populateBranches(branches) {
                branchFilter.innerHTML = '<option value="all">All Branches</option>';
                branches.forEach(branch => {
                    branchFilter.innerHTML += `<option value="${branch.id}">${branch.name}</option>`;
                });
            }
        });
    </script>
@endsection
