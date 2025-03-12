@php
    $markets = $offer->branches->groupBy('market.name');
    $remainingDays = \App\Helpers\DateHelper::calculateRemainingDays($offer->end_date);
@endphp

<div class="card w-100 d-flex flex-column">
    <div class="image-container flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="first w-100" style="top: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                @foreach ($markets as $marketName => $branches)
                    <h6 class="discount">{{ $marketName }}</h6>
                @endforeach
                <a href="#" class="wishlist" target="_blank" id="shareBtn-{{ $offer->id }}" data-id="{{ $offer->id }}" data-title="{{ $offer->title }}"><i class="fa fa-share"></i></a>
                @if ($offer->pdf)
                <a href="{{ asset('storage/' . $offer->pdf) }}" class="wishlist" target="_blank"><i class="fa fa-pdf"></i></a>
                @endif
            </div>
        </div>
        @if ($offer->cover_image)
            <img src="{{ asset('storage/' . $offer->cover_image) }}" class="img-fluid rounded thumbnail-image"
                alt="Offer Image">
        @else
            <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded thumbnail-image"
                alt="Default Image">
        @endif
    </div>
    <div class="product-detail-container p-2 d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="offer-title">
                <a href="{{ route('offer.show', $offer->id) }}">
                    {{ $offer->title }}
                </a>
            </h5>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-1 mt-auto">
            <h6 class="text-muted m-0">Valid: {{ $offer->end_date }}</h6>
            <div class="d-flex">
                <span class="buy">{{ $remainingDays }} days</span>
            </div>
        </div>
    </div>
</div>