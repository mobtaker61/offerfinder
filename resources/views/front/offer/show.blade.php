@extends('layouts.public')

@section('title', $offer->title)

@section('content')
    <div class="container mt-4">
        <div class="row">
            <main class="col-md-8" id="offer-content">
                @if ($offer->pdf)
                    <div class="pdf-viewer mb-4">
                        <iframe src="{{ asset('storage/' . $offer->pdf) }}" width="100%" height="600px"></iframe>
                    </div>
                @endif

                @if ($offer->images->isNotEmpty())
                    <div class="gallery">
                        <h5 class="widget-title text-uppercase border-bottom border-primary pb-3 mb-3">Gallery</h5>
                        <div class="row">
                            @foreach ($offer->images as $image)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $image->image) }}" data-lightbox="offer-gallery">
                                        <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded" alt="Offer Image">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
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
