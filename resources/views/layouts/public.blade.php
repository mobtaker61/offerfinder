<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>@yield('title', config('app.name', 'Offer Finder'))</title>
    <meta name="title" content="@yield('title', config('app.name', 'Offer Finder'))">
    <meta name="description" content="Find the best market offers in UAE and don't miss out on the best deals">
    <meta name="keywords" content="offer,discount,sale,big sale,price,shop,hypermarket,supermarket,market,shopping,shopping mall,uae,dubai">
    <meta name="author" content="OfferFinder">

    <!-- Browser Configuration -->
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#b4976a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Favicon and Apple Touch Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'Offer Finder'))">
    <meta property="og:description" content="Find the best market offers in UAE and don't miss out on the best deals">
    <meta property="og:image" content="{{ asset('images/preview.png') }}">
    <meta property="og:site_name" content="OfferFinder">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'Offer Finder'))">
    <meta name="twitter:description" content="Find the best market offers in UAE and don't miss out on the best deals">
    <meta name="twitter:image" content="{{ asset('images/preview.png') }}">
    <meta name="twitter:site" content="@offerfinder">
    <meta name="twitter:creator" content="@offerfinder">

    <!-- SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="English">
    <meta name="google-adsense-account" content="ca-pub-3344202725221870">

    <!-- Preconnect to External Domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">
    <link rel="preconnect" href="https://www.googletagmanager.com">

    <!-- CSS Resources -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Firebase SDK -->
    <script defer src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script defer src="https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"></script>
    <script defer src="https://www.gstatic.com/firebasejs/9.0.0/firebase-analytics-compat.js"></script>

    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "qvsf8dzrpj");
    </script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JZ2RWM7LX6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-JZ2RWM7LX6');
    </script>

    <!-- ShareThis -->
    <script defer type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=653d3e10744d850019cafbf7&product=inline-share-buttons'>
    </script>

    <!-- AMP Ads -->
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>

    <!-- Additional Styles -->
    @yield('styles')
</head>

<body>
    <header class="w-100 z-3 sticky-top" id="myHeader">
        <nav id="primary-header" class="navbar top-header navbar-expand-lg py-3 px-2">
            <div class="container-fluid mx-xl-5">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo-2.png" class="logo img-fluid">
                </a>

                
                <!-- Search Input -->
                <div class="flex-grow-1 mx-3">
                    <form action="#" method="GET" class="d-flex">
                        <!-- Location Selector Button -->
                        <button class="btn btn-outline-primary p-2" type="button" data-bs-toggle="modal" data-bs-target="#locationModal" style="width: 120px;text-align: left;overflow: hidden;border-radius: 8px;"> 
                            <span id="selectedLocation"><i class="fas fa-map-marker-alt me-2"></i>Location</span>
                        </button>
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search for offers, products, or markets...">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                </button>
                        </div>
                    </form>
                    </div>

                <!-- Main Menu -->
                        <ul class="navbar-nav mb-2 mb-lg-0 text-uppercase">
                    <li class="nav-item px-3">
                        <a class="nav-link {{ request()->routeIs('front.market.index') ? 'active' : '' }}" href="{{ route('front.market.index') }}">
                            Markets
                        </a>
                            </li>
                    <li class="nav-item px-3">
                        <a class="nav-link {{ request()->routeIs('offer.list') ? 'active' : '' }}" href="{{ route('offer.list') }}">
                            <i class="fas fa-tags me-1"></i> Offers
                        </a>
                            </li>
                    <li class="nav-item px-3">
                        <a class="nav-link {{ request()->routeIs('blog.index') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                            <i class="fas fa-blog me-1"></i> Blog
                        </a>
                            </li>
                            @guest
                    <li class="nav-item px-3">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user-circle me-1"></i> Login
                                </a>
                            </li>
                            @else
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                        </ul>

                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler border-0 d-flex d-lg-none order-3 p-2 shadow-none" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar"
                    aria-expanded="false">
                    <svg class="text-black" width="40" height="40">
                        <use xlink:href="#navbar-icon"></use>
                    </svg>
                </button>
            </div>
        </nav>
    </header>
    @if (!Request::is('/'))
    <section id="billboard" style="margin-top: -80px;">
        <div style="background-image: url(/images/background.png);background-repeat: no-repeat; width: 100%;">
            <div class="container d-flex position-relative" style="justify-content: center;">
                <div class="row flex-row-reverse align-items-center text-center padding-medium mt-md-5">
                    <h1 class="herotext display-4 fw-bold  mb-4">
                        @yield('title') -
                    </h1>
                </div>
            </div>
        </div>
    </section>
    @endif

    @yield('content')

    <!-- Google AdSense Section -->
    <div class="container my-4 text-center">
        <p>Advertisement</p>
        <amp-ad width="100vw" height="320" type="adsense" data-ad-client="ca-pub-3344202725221870"
            data-ad-slot="8646263894" data-auto-format="rspv" data-full-width="">
            <div overflow=""></div>
        </amp-ad>
    </div>

    <!-- Footer Section -->
    <footer class="bg-primary py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <!-- Logo & About Column -->
                <div class="col-md-4">
                    <div class="footer-logo mb-3">
                        <img src="{{ asset('images/logo-2.png') }}" alt="Logo" class="img-fluid" style="max-height: 60px;">
                    </div>
                    <div class="footer-brand mb-3">
                        <h5 class="footer-slogan mb-1">You're never far from a good deal</h5>
                    </div>
                    <p class="small">
                        Discover the best offers and deals from your favorite markets across UAE.
                        We bring you exclusive discounts and promotions all in one place.
                    </p>
                </div>

                <!-- Quick Menu Column -->
                <div class="col-md-2 offset-1">
                    <h5 class="footer-title mb-3">Quick Menu</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2">
                            <a href="{{ route('front.market.index') }}" class="text-decoration-none">Markets</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('offer.list') }}" class="text-decoration-none">Offers</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('blog.index') }}" class="text-decoration-none">Blog</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none">About Us</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none">Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- Official Links Column -->
                <div class="col-md-2">
                    <h5 class="footer-title mb-3">Official Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2">
                            <a href="{{ route('pages.show', 'about-us') }}" class="text-decoration-none">About Us</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pages.show', 'offer-submission') }}" class="text-decoration-none">Offer Submission</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pages.show', 'faqs') }}" class="text-decoration-none">FAQs</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pages.show', 'privacy-policy') }}" class="text-decoration-none">Privacy Policy</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pages.show', 'terms-conditions') }}" class="text-decoration-none">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact & Social Column -->
                <div class="col-md-3">
                    <h5 class="footer-title mb-3">Get in Touch</h5>
                    <ul class="list-unstyled footer-contact">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:contact@offerfinder.ae" class="text-decoration-none">
                                contact[@]offerfinder.ae
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:+1234567890" class="text-decoration-none">
                                +971 56 2858133
                            </a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span class="">Deira, Dubai, UAE</span>
                        </li>
                    </ul>

                    <div class="footer-social mt-3">
                        <h6 class="text-light mb-2">Follow Us</h6>
                        <div class="social-links">
                            <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright Bar -->
            <div class="border-top border-secondary mt-4 pt-4">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br /> Developed by <a href="https://roniplus.ae">Roni Plus</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <!-- Additional Libraries -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- Header Scroll Effect -->
    <script>
        document.addEventListener("scroll", function() {
            const header = document.getElementById("myHeader");
            if (window.scrollY > 50) {
                header.classList.add("bg-scrolled");
            } else {
                header.classList.remove("bg-scrolled");
            }
        });
    </script>

    <!-- Firebase Initialization -->
    <script>
        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        // Initialize Firebase
        let firebaseApp;
        try {
            firebaseApp = firebase.initializeApp(firebaseConfig);
        } catch (error) {
            if (error.code !== 'app/duplicate-app') {
                console.error('Firebase initialization error:', error);
            }
            firebaseApp = firebase.app();
        }

        // Initialize Firebase Cloud Messaging
        const messaging = firebase.messaging();

        // Register Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('{{ route("firebase-messaging-sw") }}')
                .then(function(registration) {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(function(error) {
                    console.error('Service Worker registration failed:', error);
                });
        }

        // Request permission and get token
        async function requestNotificationPermission() {
            try {
                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    const token = await messaging.getToken({
                        vapidKey: "{{ config('services.firebase.vapid_key') }}",
                        serviceWorkerRegistration: await navigator.serviceWorker.ready
                    });
                    await registerFcmToken(token);
                    console.log('FCM Token:', token);
                    return token;
                } else {
                    console.log('Notification permission denied');
                    return null;
                }
            } catch (error) {
                console.error('Error getting FCM token:', error);
                return null;
            }
        }

        // Register FCM token with server
        async function registerFcmToken(token) {
            try {
                const response = await fetch('{{ route("fcm-tokens.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        fcm_token: token
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to register FCM token');
                }
                console.log('FCM token registered successfully');
            } catch (error) {
                console.error('Error registering FCM token:', error);
                throw error;
            }
        }

        // Handle foreground messages
        messaging.onMessage((payload) => {
            console.log('Received foreground message:', payload);
            if (Notification.permission === 'granted') {
                new Notification(payload.notification.title, {
                    body: payload.notification.body,
                    icon: '/images/logo.png'
                });
            }
        });

        // Initialize when document is ready
        document.addEventListener('DOMContentLoaded', () => {
            requestNotificationPermission();
        });
    </script>

    <!-- Location Selection Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div id="locationData" data-locations='@json($locationData)' data-user-location='@json(session("user_location"))' style="display: none;"></div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel">Select Your Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Current Location Button -->
                    <div class="mb-4">
                        <button class="btn btn-primary w-100" id="getCurrentLocation">
                            <i class="fas fa-location-arrow me-2"></i>Use My Current Location
                        </button>
                    </div>

                    <!-- Step 1: Emirates -->
                    <div id="step1" class="location-step">
                        <h6 class="mb-3">Select Emirate</h6>
                        <div class="row g-3">
                            @foreach($locationData as $emirate => $districts)
                            <div class="col-md-4">
                                <button class="btn btn-outline-primary w-100 emirate-btn" data-emirate="{{ $emirate }}">
                                    {{ $emirate }}
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 2: Districts -->
                    <div id="step2" class="location-step d-none">
                        <div class="d-flex align-items-center mb-3">
                            <button class="btn btn-link p-0 me-3 back-btn">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h6 class="mb-0">Select District</h6>
                        </div>
                        <div class="row g-3" id="districtsList">
                            <!-- Districts will be loaded dynamically -->
                        </div>
                    </div>

                    <!-- Step 3: Neighborhoods -->
                    <div id="step3" class="location-step d-none">
                        <div class="d-flex align-items-center mb-3">
                            <button class="btn btn-link p-0 me-3 back-btn">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h6 class="mb-0">Select Neighborhood</h6>
                        </div>
                        <div class="row g-3" id="neighborhoodsList">
                            <!-- Neighborhoods will be loaded dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this to your existing styles -->
    <style>
        .location-step {
            min-height: 300px;
        }

        .location-step .btn {
            padding: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .location-step .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            color: #0d6efd;
            text-decoration: none;
        }

        .back-btn:hover {
            color: #0a58ca;
        }

        #selectedLocation {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .form-control-lg {
            height: 48px;
            font-size: 1rem;
        }
    </style>

    <!-- Add this to your existing scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Location Selection Logic
            const locationModal = document.getElementById('locationModal');
            const selectedLocation = document.getElementById('selectedLocation');
            const steps = document.querySelectorAll('.location-step');
            const backButtons = document.querySelectorAll('.back-btn');
            const districtsList = document.getElementById('districtsList');
            const neighborhoodsList = document.getElementById('neighborhoodsList');
            const getCurrentLocationBtn = document.getElementById('getCurrentLocation');

            // Get location data from backend
            const locationData = JSON.parse(document.getElementById('locationData').dataset.locations);
            const userLocationData = document.getElementById('locationData').dataset.userLocation;
            
            // Set initial location from session if available
            if (userLocationData && userLocationData !== 'null') {
                const userLocation = JSON.parse(userLocationData);
                const distanceKm = userLocation.distance.toFixed(2);
                selectedLocation.textContent = `${userLocation.name} (${distanceKm}km)`;
            }

            // Get current location
            getCurrentLocationBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert('Geolocation is not supported by your browser');
                    return;
                }

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Getting location...';

                navigator.geolocation.getCurrentPosition(
                    async function(position) {
                        const { latitude, longitude } = position.coords;
                        
                        // Find nearest neighborhood
                        let nearestNeighborhood = null;
                        let shortestDistance = Infinity;

                        // Function to calculate distance between two points using Haversine formula
                        function calculateDistance(lat1, lon1, lat2, lon2) {
                            const R = 6371; // Earth's radius in kilometers
                            const dLat = (lat2 - lat1) * Math.PI / 180;
                            const dLon = (lon2 - lon1) * Math.PI / 180;
                            const a = 
                                Math.sin(dLat/2) * Math.sin(dLat/2) +
                                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                                Math.sin(dLon/2) * Math.sin(dLon/2);
                            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                            return R * c;
                        }

                        // Iterate through all locations to find nearest neighborhood
                        for (const [emirate, districts] of Object.entries(locationData)) {
                            for (const [district, neighborhoods] of Object.entries(districts)) {
                                for (const neighborhood of neighborhoods) {
                                    if (neighborhood.lat && neighborhood.lng) {
                                        const distance = calculateDistance(
                                            latitude,
                                            longitude,
                                            parseFloat(neighborhood.lat),
                                            parseFloat(neighborhood.lng)
                                        );

                                        if (distance < shortestDistance) {
                                            shortestDistance = distance;
                                            nearestNeighborhood = {
                                                name: neighborhood.name,
                                                emirate: emirate,
                                                district: district,
                                                distance: distance
                                            };
                                        }
                                    }
                                }
                            }
                        }

                        if (nearestNeighborhood) {
                            // Format distance to 2 decimal places
                            const distanceKm = nearestNeighborhood.distance.toFixed(2);
                            selectedLocation.textContent = `${nearestNeighborhood.name} (${distanceKm}km)`;
                            
                            // Save location to session via AJAX
                            try {
                                const response = await fetch('{{ route("location.save") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify(nearestNeighborhood)
                                });

                                if (!response.ok) {
                                    throw new Error('Failed to save location');
                                }
                            } catch (error) {
                                console.error('Error saving location:', error);
                            }
                            
                            locationModal.querySelector('.btn-close').click();
                        } else {
                            alert('Could not find nearby neighborhoods. Please select manually.');
                        }

                        getCurrentLocationBtn.disabled = false;
                        getCurrentLocationBtn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Use My Current Location';
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        alert('Error getting your location. Please select manually.');
                        getCurrentLocationBtn.disabled = false;
                        getCurrentLocationBtn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Use My Current Location';
                    }
                );
            });

            // Emirate selection
            document.querySelectorAll('.emirate-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const emirate = this.dataset.emirate;
                    showDistricts(emirate);
                    steps[0].classList.add('d-none');
                    steps[1].classList.remove('d-none');
                });
            });

            // Back button functionality
            backButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const currentStep = this.closest('.location-step');
                    const prevStep = currentStep.previousElementSibling;
                    currentStep.classList.add('d-none');
                    prevStep.classList.remove('d-none');
                });
            });

            // Show districts for selected emirate
            function showDistricts(emirate) {
                districtsList.innerHTML = '';
                if (locationData[emirate]) {
                    Object.keys(locationData[emirate]).forEach(district => {
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-4';
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-outline-primary w-100 district-btn';
                        btn.textContent = district;
                        btn.dataset.district = district;
                        btn.dataset.emirate = emirate;
                        btn.addEventListener('click', function() {
                            showNeighborhoods(this.dataset.emirate, this.dataset.district);
                            steps[1].classList.add('d-none');
                            steps[2].classList.remove('d-none');
                        });
                        colDiv.appendChild(btn);
                        districtsList.appendChild(colDiv);
                    });
                }
            }

            // Show neighborhoods for selected district
            function showNeighborhoods(emirate, district) {
                neighborhoodsList.innerHTML = '';
                if (locationData[emirate] && locationData[emirate][district]) {
                    locationData[emirate][district].forEach(neighborhood => {
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-4';
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-outline-primary w-100 neighborhood-btn';
                        btn.textContent = neighborhood.name || neighborhood;
                        btn.dataset.neighborhood = neighborhood.name || neighborhood;
                        btn.dataset.district = district;
                        btn.dataset.emirate = emirate;
                        btn.addEventListener('click', async function() {
                            const location = {
                                name: this.dataset.neighborhood,
                                emirate: this.dataset.emirate,
                                district: this.dataset.district,
                                distance: 0 // Since it's manually selected, we'll set distance to 0
                            };
                            
                            selectedLocation.textContent = location.name;
                            
                            // Save location to session via AJAX
                            try {
                                const response = await fetch('{{ route("location.save") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify(location)
                                });

                                if (!response.ok) {
                                    throw new Error('Failed to save location');
                                }
                            } catch (error) {
                                console.error('Error saving location:', error);
                            }
                            
                            locationModal.querySelector('.btn-close').click();
                        });
                        colDiv.appendChild(btn);
                        neighborhoodsList.appendChild(colDiv);
                    });
                }
            }

            // Reset modal when closed
            locationModal.addEventListener('hidden.bs.modal', function() {
                steps.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.remove('d-none');
                    } else {
                        step.classList.add('d-none');
                    }
                });
            });
        });
    </script>

    @yield('scripts')
<style>
    .footer-title {
        color: #fff;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: #0d6efd;
    }

    .footer-slogan {
        color: #fcd100;
    }

    .footer-links a:hover {
        color: #fcd100 !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }

    .footer-contact i {
        width: 20px;
        text-align: center;
    }

    .footer-social .social-links a {
        display: inline-block;
        width: 32px;
        height: 32px;
        line-height: 32px;
        text-align: center;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .footer-social .social-links a:hover {
        color: #fff !important;
        background-color: #0d6efd;
        transform: translateY(-3px);
    }

    .footer-logo img {
        filter: brightness(0) invert(1);
    }

    @media (max-width: 768px) {
        .footer-title {
            margin-top: 1.5rem;
        }
    }

    /* Market Avatar Slider Styles */
    .market-avatar {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .market-avatar:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Upcoming Offers Styles */
    .upcoming-offers .card {
        transition: transform 0.3s ease;
    }

    .upcoming-offers .card:hover {
        transform: translateY(-5px);
    }

    .upcoming-offers .badge {
        font-size: 0.8rem;
        padding: 0.5em 1em;
    }

    /* Blog Section Styles */
    .blog-section .card {
        transition: transform 0.3s ease;
        border: none;
    }

    .blog-section .card:hover {
        transform: translateY(-5px);
    }

    .blog-section .card-img-top {
        height: 200px;
        object-fit: cover;
    }
</style>
</body>

</html>