<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="OfferFinder">
    <meta name="keywords"
        content="offer,discount,sale,big sale,price,shop,hypermarket,supermarket,market,shopping,shopping mall">
    <meta name="description" content="Find the best market offers in uae and font miss out on the best deals">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    <meta name="yandex" content="index, follow">
    <meta name="referrer" content="always">
    <meta name="rating" content="general">
    <meta name="distribution" content="global">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="English">
    <meta name="generator" content="OfferFinder">
    <meta property="og:title" content="@yield('title', config('app.name', 'Offer Finder'))">
    <meta property="og:description" content="Find the best market offers in uae and font miss out on the best deals">
    <meta property="og:image" content="preview.png">
    <meta property="og:url" content="https://offerfinder.com">
    <meta property="og:site_name" content="OfferFinder">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@offerfinder">
    <meta name="twitter:creator" content="@offerfinder">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="Find the best market offers in uae and font miss out on the best deals">
    <meta name="twitter:image" content="preview.png">

    <script>
        window.firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}",
            vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}"
        };
    </script>
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=653d3e10744d850019cafbf7&product=inline-share-buttons'
        async='async'></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Offer Finder'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JZ2RWM7LX6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-JZ2RWM7LX6');
    </script>
    <meta name="google-adsense-account" content="ca-pub-3344202725221870">
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <!--style sheet-->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/vendor.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('styles')
</head>

<body>
    <header class="w-100 z-3 sticky-top" id="myHeader">
        <nav id="primary-header" class="navbar top-header navbar-expand-lg py-3 px-2">
            <div class="container-fluid mx-xl-5">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo-2.png" class="logo img-fluid">
                </a>
                <button class="navbar-toggler border-0 d-flex d-lg-none order-3 p-2 shadow-none" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar"
                    aria-expanded="false">
                    <svg class="text-black" width="40" height="40">
                        <use xlink:href="#navbar-icon"></use>
                    </svg>
                </button>
                <div class="header-bottom offcanvas offcanvas-end" id="bdNavbar"
                    aria-labelledby="bdNavbarOffcanvasLabel">
                    <div class="offcanvas-header p-4">
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                            aria-label="Close" data-bs-target="#bdNavbar"></button>
                    </div>
                    <div class="offcanvas-body align-items-center justify-content-end">
                        <ul class="navbar-nav mb-2 mb-lg-0 text-uppercase">
                            <li class="nav-item px-4">
                                <a class="nav-link active p-0" aria-current="page"
                                    href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link active p-0" aria-current="page"
                                    href="{{ route('front.market.index') }}">Markets</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link active p-0" aria-current="page"
                                    href="{{ route('offer.list') }}">Offers</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link active p-0" aria-current="page"
                                    href="{{ route('blog.index') }}">Blog</a>
                            </li>
                            @guest
                            <li class="nav-item px-4">
                                <a class="nav-link p-0" href="{{ route('login') }}">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </a>
                            </li>
                            @else
                            <li class="nav-item dropdown px-4">
                                <a class="nav-link p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
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
                    </div>
                </div>
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
    <footer class="bg-danger py-5 mt-5">
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
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br/> Developed by <a href="https://roniplus.ae">Roni Plus</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="/js/jquery-1.11.0.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="/js/plugins.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> <!--cdn link-->
    <script type="text/javascript" src="/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        document.addEventListener("scroll", function() {
            const header = document.getElementById("myHeader");
            if (window.scrollY > 50) { // Adjust the scroll threshold as needed
                header.classList.add("bg-scrolled");
            } else {
                header.classList.remove("bg-scrolled");
            }
        });
    </script>
    @yield('scripts')
</body>

</html>

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
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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