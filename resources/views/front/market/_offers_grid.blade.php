@foreach($offers as $offer)
<div class="col-md-4">
    <div class="card offer-card">
        <img src="{{ asset('storage/' . $offer->cover_image) }}" class="card-img-top offer-image" alt="{{ $offer->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $offer->title }}</h5>
            <p class="card-text text-muted">
                <small>
                    <i class="far fa-calendar-alt"></i> Valid until {{ $offer->end_date->format('M d, Y') }}
                </small>
            </p>
            <a href="{{ route('offer.show', $offer) }}" class="btn btn-primary btn-sm">View Details</a>
        </div>
    </div>
</div>
@endforeach 