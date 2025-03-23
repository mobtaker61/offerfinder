@extends('layouts.public')

@section('title', $offer->title)

@section('styles')
<style>
    .gallery-container {
        display: flex;
        overflow-x: auto;
        position: relative;
        min-height: 300px;
        max-height: 500px;
        gap: 15px;
        scrollbar-width: thin;
        scrollbar-color: #0d6efd #f0f0f0;
        background: #f8f9fa;
        border-radius: 8px;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    .gallery-container::-webkit-scrollbar {
        height: 8px;
    }

    .gallery-container::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 4px;
    }

    .gallery-container::-webkit-scrollbar-thumb {
        background-color: #0d6efd;
        border-radius: 4px;
    }

    .gallery-image {
        position: relative;
        flex: 0 0 auto;
        width: 300px;
        height: 100%;
    }

    .gallery-image>div {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-image img {
        max-width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            @if ($offer->images->isNotEmpty())
            <div class="gallery mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom border-primary pb-3 mb-3">
                    <h5 class="widget-title text-uppercase mb-0">Gallery</h5>
                    <span class="text-muted">Click to Enlarge Image</span>
                </div>
                <div class="gallery-container">
                    @foreach ($offer->images as $image)
                    <div class="gallery-image">
                        <div>
                            <a href="{{ asset('storage/' . $image->image) }}" data-lightbox="offer-gallery">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Offer Image" loading="lazy">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <main class="col-md-8" id="offer-content">
            <!-- PDF Section -->
            @if ($offer->pdf)
            <div class="pdf-viewer mb-4" hidden>
                <iframe src="{{ asset('storage/' . $offer->pdf) }}" width="100%" height="600px"></iframe>
            </div>
            @endif

            <!-- Products Section -->
            @if($offer->images->flatMap->offerProducts->isNotEmpty())
            <div class="products mt-4">
                <h5 class="widget-title text-uppercase border-bottom border-primary pb-3 mb-3">Products</h5>

                @foreach($offer->images as $image)
                @if($image->offerProducts->isNotEmpty())
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <div style="width: 50px; height: 50px; overflow: hidden; margin-right: 10px;">
                            <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h6 class="mb-0">Products in this image</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Variant</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($image->offerProducts as $offerProduct)
                                    <tr>
                                        <td>{{ $offerProduct->product->name }}</td>
                                        <td>{{ $offerProduct->variant ?? '-' }}</td>
                                        <td>
                                            @if($offerProduct->quantity)
                                            {{ $offerProduct->quantity }} {{ $offerProduct->unit ?? '' }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>{{ $offerProduct->price ? number_format($offerProduct->price, 2) . ' AED' : '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
            <!-- ShareThis BEGIN -->
            <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
        </main>
        <aside class="col-md-4" id="info-sidebar">
            <div class="post-sidebar">
                <div class="reviews-components widget sidebar-categories border border-primary rounded-4 p-3 mb-5">
                    <h5 class="widget-title text-uppercase border-bottom border-primary pb-3 mb-3">Offer Details</h5>
                    <table class="table">
                        <img src="{{ asset('storage/' . $offer->cover_image) }}" class="img-fluid"
                            alt="{{ $offer->title }}">
                        <tbody>
                            <tr>
                                <th class="heading-color" scope="row">Start Date:</th>
                                <td class="text-end">{{ \Carbon\Carbon::parse($offer->start_date)->format('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="heading-color" scope="row">End Date:</th>
                                <td class="text-end">
                                    @if (\Carbon\Carbon::parse($offer->end_date)->isFuture())
                                    <span class="badge bg-success">Live</span>
                                    @else
                                    <span class="badge bg-dark">Finish</span>
                                    @endif
                                    {{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="heading-color" scope="row">Emirates:</th>
                                <td class="text-end">{{ $offer->clients }}</td>
                            </tr>
                            <tr>
                                <th class="heading-color" scope="row">Market:</th>
                                <td class="text-end">{{ $offer->tags }}</td>
                            </tr>
                            <tr>
                                <th class="heading-color" scope="row">Branchs:</th>
                                <td class="text-end">{{ $offer->category }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="reviews-components widget block-tag border border-primary rounded-4 p-3 mb-5">
                    <h5 class="widget-title text-uppercase border-bottom border-primary pb-3 mb-3">In Branches</h5>
                    @if ($offer->branches->isNotEmpty())
                    <div class="accordion" id="branchAccordion">
                        @foreach ($offer->branches as $branch)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $branch->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $branch->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $branch->id }}">{{ $branch->name }}</button>
                            </h2>
                            <div id="collapse{{ $branch->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $branch->id }}" data-bs-parent="#branchAccordion">
                                <div class="accordion-body">
                                    <p>Address: <span class="float-end">{{ $branch->address }}</span></p>
                                    <p>Working Hours: <span
                                            class="float-end">{{ $branch->working_hours }}</span></p>
                                    <p>Customer Service: <span
                                            class="float-end">{{ $branch->customer_service }}</span></p>
                                    <p>Location: <span class="float-end"><a
                                                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch->location) }}"
                                                target="_blank">View on Google Maps</a></span></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>No branch details available.</p>
                    @endif
                </div>

                <div class="reviews-components widget block-tag border border-primary rounded-4 p-3 mb-5"
                    id="marketDetail">
                    <h5 class="widget-title text-uppercase border-bottom border-primary pb-3 mb-3">Market Info</h5>
                    @if ($market)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $market->logo) }}" class="img-fluid"
                            alt="{{ $market->name }}">
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th class="heading-color" scope="row">Name:</th>
                                <td class="text-end">{{ $market->name }}</td>
                            </tr>
                            <tr>
                                <th class="heading-color" scope="row">Website:</th>
                                <td class="text-end"><a href="{{ $market->website }}"
                                        target="_blank">{{ $market->website }}</a></td>
                            </tr>
                            <tr>
                                <th class="heading-color" scope="row">WhatsApp:</th>
                                <td class="text-end">{{ $market->whatsapp }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <p>No market details available.</p>
                    @endif
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "cards",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // Auto-scroll functionality for gallery with loop
    document.addEventListener('DOMContentLoaded', function() {
        const galleryContainer = document.querySelector('.gallery-container');
        let scrollInterval;
        let isScrollingForward = true;
        const scrollSpeed = 0.7; // Slightly increased speed
        const scrollIntervalTime = 16; // 60fps for smooth animation

        function startAutoScroll() {
            scrollInterval = setInterval(() => {
                const maxScroll = galleryContainer.scrollWidth - galleryContainer.clientWidth;
                
                // If scrolling forward and reached the end, change direction
                if (isScrollingForward && galleryContainer.scrollLeft >= maxScroll) {
                    isScrollingForward = false;
                }
                // If scrolling backward and reached the start, change direction
                else if (!isScrollingForward && galleryContainer.scrollLeft <= 0) {
                    isScrollingForward = true;
                }

                // Scroll in the current direction
                if (isScrollingForward) {
                    galleryContainer.scrollLeft += scrollSpeed;
                } else {
                    galleryContainer.scrollLeft -= scrollSpeed;
                }
            }, scrollIntervalTime);
        }

        function stopAutoScroll() {
            clearInterval(scrollInterval);
        }

        // Start auto-scroll
        startAutoScroll();

        // Pause on hover
        galleryContainer.addEventListener('mouseenter', stopAutoScroll);
        galleryContainer.addEventListener('mouseleave', startAutoScroll);

        // Pause on touch for mobile devices
        galleryContainer.addEventListener('touchstart', stopAutoScroll);
        galleryContainer.addEventListener('touchend', startAutoScroll);

        // Stop scrolling when the page is not visible
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoScroll();
            } else {
                startAutoScroll();
            }
        });
    });
</script>
@endsection