@php
$markets = $offer->branches->groupBy('market.name');
$remainingDays = \App\Helpers\DateHelper::calculateRemainingDays($offer->end_date);
@endphp

<div class="card w-100 d-flex flex-column">
    <div class="image-container flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="first w-100" style="top: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Market Avatars Overlay -->
                @foreach ($markets as $marketName => $branches)
                @php
                $market = $branches->first()->market;
                @endphp
                <div class="market-avatar" title="{{ $marketName }}">
                    <img src="{{ $market->logo ? asset('storage/' . $market->avatar) : 'https://placehold.co/40x40?text=avatar' }}"
                        alt="{{ $marketName }}"
                        class="rounded-circle"
                        style="width: 40px; height: 40px;">
                </div>
                @endforeach
                <!-- Share Button -->
                <a href="#" class="wishlist" target="_blank" id="shareBtn-{{ $offer->id }}"
                    data-id="{{ $offer->id }}" data-title="{{ $offer->title }}">
                    <i class="fa fa-share"></i>
                </a>
            </div>
        </div>

        @if ($offer->cover_image)
        <div class="image-overlay"></div>
        <img src="{{ asset('storage/' . $offer->cover_image) }}" class="img-fluid rounded thumbnail-image"
            alt="Offer Image">
        @else
        <div class="image-overlay"></div>
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
            <h6 class="text-muted m-0">Valid: {{ $offer->end_date->format('d M Y') }}</h6>
            <div class="d-flex">
                <span class="buy">{{ $remainingDays }} days</span>
            </div>
        </div>
    </div>
</div>

<style>
.image-container {
    position: relative;
}

.image-container img {
    object-fit: fill;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 40%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);
    z-index: 1;
    pointer-events: none;
    border-radius: 10px;
}

.first {
    z-index: 2; /* Ensure the market avatars and share button stay above the gradient */
}
</style>