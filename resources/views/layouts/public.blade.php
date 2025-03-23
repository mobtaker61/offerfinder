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
                            <li class="nav-item dropdown px-4">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false"
                                    class="nav-link p-0 dropdown-toggle">Info</a>
                                <ul class="dropdown-menu">
                                    <li class="border-bottom"><a href="{{ url('/') }}"
                                            class="dropdown-item">About
                                            us</a></li>
                                    <li class="border-bottom"><a href="{{ url('/') }}"
                                            class="dropdown-item">Collabration</a></li>
                                    <li class="border-bottom"><a href="{{ url('/') }}"
                                            class="dropdown-item">Contact us</a></li>
                                </ul>
                            </li>
                            @guest
                                <li class="nav-item px-4">
                                    <a class="nav-link p-0" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item px-4">
                                    <a class="nav-link p-0" href="{{ route('register') }}">Register</a>
                                </li>
                            @else
                                <li class="nav-item dropdown px-4">
                                    <a class="nav-link p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
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
                            @yield('title')
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

    <footer id="footer" class="bg-danger">
        <div class="container text-white padding-medium">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <h3 class="display-1 text-white fw-bold">
                        Let's Talk
                    </h3>
                </div>
                <div class="col-md-3 ">
                    <p>Justo, a quisque in accumsan dignissim volutpat quis.Sit pellentesque faucibus arcu lacinia
                        egestas augue. Sit volutpat vel dui ultricies massa. Sit pellentesque faucibus arcu lacinia
                        egestas augue. Sit volutpat vel dui ultricies massa.</p>
                </div>
                <div class="offset-md-1 col-md-3">
                    <div>
                        <p>
                            <u>offer@roniplus.ae</u>
                        </p>
                        <p>
                            Hor Al Anz, Deira</br>
                            Dubai, UAE
                        </p>
                    </div>
                    <div class="social-links">
                        <ul class="d-flex gap-3 list-unstyled">
                            <li>
                                <a href="#">
                                    <svg class="behance" width="30" height="30">
                                        <use xlink:href="#behance" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg class="pinterest" width="30" height="30">
                                        <use xlink:href="#pinterest" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg class="instagram" width="30" height="30">
                                        <use xlink:href="#instagram" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg class="twitter" width="30" height="30">
                                        <use xlink:href="#twitter" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg class="facebook" width="30" height="30">
                                        <use xlink:href="#facebook" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-white">
        <div class="container text-white">
            <div class="row py-1">
                <div class="col text-start">
                    <p>© {{ date('Y') }} Digital. All rights reserved.</p>
                </div>
                <div class="col text-end">
                    Developed by: <a href="https://roniplus.ae/" target="_blank"
                        class="text-decoration-underline fw-bold">Roni Plus Co. L.L.C</a>
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
