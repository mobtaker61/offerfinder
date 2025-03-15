@extends('layouts.public')

@section('title', 'Offers')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <h4>Filters</h4>
                <form id="offerFilterForm">
                    <div class="mb-3">
                        <label for="emirateFilter" class="form-label">Emirate</label>
                        <select name="emirate_id" id="emirateFilter" class="form-control">
                            <option value="all">All Emirates</option>
                            @foreach ($emirates as $emirate)
                                <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="marketFilter" class="form-label">Market</label>
                        <select name="market_id" id="marketFilter" class="form-control" disabled>
                            <option value="all">All Markets</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="branchFilter" class="form-label">Branch</label>
                        <select name="branch_id" id="branchFilter" class="form-control" disabled>
                            <option value="all">All Branches</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select name="status" id="statusFilter" class="form-control">
                            <option value="all">All</option>
                            <option value="active">Active</option>
                            <option value="finished">Finished</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sortFilter" class="form-label">Sort By Date</label>
                        <select name="sort" id="sortFilter" class="form-control">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="display: none;">Apply Filters</button>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h4>Offers</h4>
                <div class="row" id="offerList">
                    @foreach ($offers as $offer)
                        <div class="col-md-4 mb-4">
                            @include('components.offer-card', ['offer' => $offer])
                        </div>
                    @endforeach
                </div>
                <div id="paginationLinks">
                    {{ $offers->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let emirateFilter = document.getElementById('emirateFilter');
            let marketFilter = document.getElementById('marketFilter');
            let branchFilter = document.getElementById('branchFilter');
            let offerFilterForm = document.getElementById('offerFilterForm');
            let statusFilter = document.getElementById('statusFilter');
            let sortFilter = document.getElementById('sortFilter');

            emirateFilter.addEventListener('change', function() {
                let emirateId = this.value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('getMarketsByEmirate') }}?emirate_id=" + emirateId, {
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        populateMarkets(data.markets);
                        populateBranches([]);
                        marketFilter.disabled = false;
                        applyFilters();
                    })
                    .catch(error => console.error("Error:", error));
            });

            marketFilter.addEventListener('change', function() {
                let marketId = this.value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('getBranchesByMarket') }}?market_id=" + marketId, {
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        populateBranches(data.branches);
                        branchFilter.disabled = false;
                        applyFilters();
                    })
                    .catch(error => console.error("Error:", error));
            });

            function applyFilters() {
                let formData = new FormData(offerFilterForm);
                let queryString = new URLSearchParams(formData).toString();
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('offer.filter') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify(Object.fromEntries(formData))
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Offers received:", data.offers); // Debugging line
                        updateOfferList(data.offers.data); // Access the data property of the paginated result
                    })
                    .catch(error => console.error("Error:", error));
            }

            branchFilter.addEventListener('change', applyFilters);
            statusFilter.addEventListener('change', applyFilters);
            sortFilter.addEventListener('change', applyFilters);

            function updateOfferList(offers) {
                let offerList = document.getElementById('offerList');
                offerList.innerHTML = '';
                if (offers.length > 0) {
                    offers.forEach(offer => {
                        fetch(`{{ url('offer/card') }}/${offer.id}`)
                            .then(response => response.text())
                            .then(html => {
                                offerList.innerHTML +=
                                    `<div class="col-md-4 mb-4">${html}</div>`;
                                addShareButtonListener(offer.id); // Add share button listener
                            })
                            .catch(error => console.error("Error:", error));
                    });
                } else {
                    offerList.innerHTML = '<div class="col-12"><p>No offers available.</p></div>';
                }
            }

            function addShareButtonListener(offerId) {
                let shareBtn = document.getElementById(`shareBtn-${offerId}`);
                shareBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    if (navigator.share) {
                        navigator.share({
                            title: document.title,
                            text: `Check out this offer: ${shareBtn.dataset.title}`,
                            url: `{{ url('offer') }}/${offerId}`
                        }).then(() => {
                            console.log('Thanks for sharing!');
                        }).catch(console.error);
                    } else {
                        alert('Web Share API is not supported in your browser.');
                    }
                });
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
