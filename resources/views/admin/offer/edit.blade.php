@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Offer</h2>

    <form action="{{ route('offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Master Dropdown: Select Market -->
        <div class="mb-3">
            <label class="form-label">Select Market</label>
            <select id="marketSelect" class="form-control" required>
                @foreach ($markets as $market)
                    <option value="{{ $market->id }}" {{ in_array($market->id, $offer->branches->pluck('market_id')->unique()->toArray()) ? 'selected' : '' }}>
                        {{ $market->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Child Dropdown: Select Branch -->
        <div class="mb-3">
            <label class="form-label">Select Branches</label>
            <select name="branch_ids[]" id="branchSelect" class="form-control" multiple required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ in_array($branch->id, $offer->branches->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $offer->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $offer->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover Image</label><br>
            @if ($offer->cover_image)
                <img src="{{ asset('storage/' . $offer->cover_image) }}" width="150">
            @endif
            <input type="file" name="cover_image" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label class="form-label">Offer PDF</label>
            <input type="file" name="pdf" class="form-control">
        </div>

        <!-- Offer Image Gallery -->
        <div class="mb-3">
            <label class="form-label">Current Offer Images</label><br>
            @foreach ($offer->images as $image)
                <img src="{{ asset('storage/' . $image->image) }}" width="80" class="m-1">
            @endforeach
        </div>

        <div class="mb-3">
            <label class="form-label">Add More Images</label>
            <input type="file" name="offer_images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-success">Update Offer</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let marketSelect = document.getElementById('marketSelect');
    let branchSelect = document.getElementById('branchSelect');

    marketSelect.addEventListener('change', function() {
        let marketId = this.value;
        branchSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/get-branches-by-market/${marketId}`)
            .then(response => response.json())
            .then(data => {
                branchSelect.innerHTML = '';
                data.branches.forEach(branch => {
                    let selected = {{ json_encode($offer->branches->pluck('id')->toArray()) }};
                    let isSelected = selected.includes(branch.id) ? 'selected' : '';
                    branchSelect.innerHTML += `<option value="${branch.id}" ${isSelected}>${branch.name}</option>`;
                });
            });
    });
});
</script>

@endsection
