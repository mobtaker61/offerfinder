@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Offers Management</h2>
    <a href="{{ route('offers.create') }}" class="btn btn-primary my-3">Add New Offer</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Branches</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Cover Image</th>
                <th>PDF</th>
                <th>Gallery</th>
                <th>VIP</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                <tr>
                    <td>{{ $offer->title }}</td>
                    <td>
                        @php
                            $markets = $offer->branches->groupBy('market.name');
                        @endphp
                        @foreach ($markets as $marketName => $branches)
                            <span class="badge bg-danger">{{ $marketName }}</span><br/>
                            @foreach ($branches as $branch)
                                <span class="badge bg-info">{{ $branch->name }}</span>
                            @endforeach
                        @endforeach
                    </td>
                    <td>{{ $offer->start_date }}</td>
                    <td>{{ $offer->end_date }}</td>
                    <td>
                        @if ($offer->cover_image)
                            <img src="{{ asset('storage/' . $offer->cover_image) }}" width="80">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @if ($offer->pdf)
                            <a href="{{ asset('storage/' . $offer->pdf) }}" target="_blank" class="btn btn-sm btn-warning">View PDF</a>
                        @else
                            No PDF
                        @endif
                    </td>
                    <td>
                        @if ($offer->images->count() > 0)
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#galleryModal{{ $offer->id }}">
                                View Gallery
                            </button>

                            <!-- Modal for Image Gallery -->
                            <div class="modal fade" id="galleryModal{{ $offer->id }}" tabindex="-1" aria-labelledby="galleryLabel{{ $offer->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Offer Gallery - {{ $offer->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($offer->images as $image)
                                                <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid mb-2">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            No Images
                        @endif
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="vipSwitch{{ $offer->id }}" {{ $offer->vip ? 'checked' : '' }} data-offer-id="{{ $offer->id }}">
                            <label class="form-check-label" for="vipSwitch{{ $offer->id }}"></label>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $offers->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.form-check-input').forEach(function(switchElement) {
        switchElement.addEventListener('change', function() {
            let offerId = this.getAttribute('data-offer-id');
            let isVip = this.checked;

            fetch(`/offers/${offerId}/toggle-vip`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ vip: isVip })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to update VIP status');
                    this.checked = !isVip;
                }
            })
            .catch(error => {
                console.error('Error updating VIP status:', error);
                alert('Failed to update VIP status');
                this.checked = !isVip;
            });
        });
    });
});
</script>

@endsection
