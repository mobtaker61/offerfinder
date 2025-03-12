<h3 class="text-center mb-4">Live Offers</h3>
<div class="row">
    @foreach ($offers as $offer)
        <div class="col-md-3 mb-4 d-flex align-items-stretch">
            <div class="card w-100 d-flex flex-column">
                <div class="image-container flex-grow-1 d-flex align-items-center justify-content-center">
                    <div class="first w-100" style="top: 10px;">
                        <div class="d-flex justify-content-between align-items-center">
                            @php
                                $markets = $offer->branches->groupBy('market.name');
                            @endphp
                            @foreach ($markets as $marketName => $branches)
                                <h6 class="discount">{{ $marketName }}</h6>
                            @endforeach
                            @if ($offer->pdf)
                                <a href="{{ asset('storage/' . $offer->pdf) }}" class="wishlist" target="_blank"><i
                                        class="fa fa-pdf"></i></a>
                            @endif
                        </div>
                    </div>
                    @if ($offer->cover_image)
                        <img src="{{ asset('storage/' . $offer->cover_image) }}"
                            class="img-fluid rounded thumbnail-image" alt="Offer Image">
                    @else
                        <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded thumbnail-image"
                            alt="Default Image">
                    @endif
                </div>
                <div class="product-detail-container p-2 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="offer-title">
                            <a href="{{ route('offer.show', $offer->id) }}">
                                {{ $offer->title }}
                            </a>
                        </h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 mt-auto">
                        <h6 class="text-muted m-0">Valid: {{ $offer->end_date }}</h6>
                        <div class="d-flex">
                            @php
                                $remainingDays = \App\Helpers\DateHelper::calculateRemainingDays($offer->end_date);
                            @endphp
                            <span class="buy">{{ $remainingDays }} days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($offers->hasMorePages())
    <div class="text-center mt-3">
        <button id="loadMore" class="btn btn-outline-primary" data-page="{{ $offers->currentPage() + 1 }}">Load
            More</button>
    </div>
@endif

<script>
    document.addEventListener("click", function(event) {
        if (event.target.id === "loadMore") {
            let page = event.target.dataset.page;
            let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch("{{ route('home') }}?page=" + page, {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    }
                })
                .then(response => response.text())
                .then(html => {
                    let offerList = document.getElementById("offerList");
                    offerList.insertAdjacentHTML("beforeend", html);
                    event.target.dataset.page = parseInt(page) + 1;

                    if (!html.includes("Load More")) {
                        event.target.remove();
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });
</script>
