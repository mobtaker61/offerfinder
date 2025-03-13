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
            <select id="marketSelect" name="market_id" class="form-control" required>
                <option value="">Select Market</option>
                @foreach ($markets as $market)
                    <option value="{{ $market->id }}" {{ $offer->market_id == $market->id ? 'selected' : '' }}>{{ $market->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Child Dropdown: Select Branch -->
        <div class="mb-3">
            <label class="form-label">Select Branches</label>
            <select name="branch_ids[]" id="branchSelect" class="form-control" multiple required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ in_array($branch->id, $offer->branches->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple branches</small>
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
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $offer->start_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $offer->end_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Offer PDF</label>
            <input type="file" name="pdf" class="form-control" accept="application/pdf">
        </div>

        <!-- Offer Image Gallery Upload -->
        <div class="mb-3">
            <label class="form-label">Offer Gallery Images</label>
            <input type="file" name="offer_images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Update Offer</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let marketSelect = document.getElementById('marketSelect');
    let branchSelect = document.getElementById('branchSelect');

    marketSelect.addEventListener('change', function() {
        let marketId = this.value;
        branchSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/get-branches-by-market?market_id=${marketId}`)
            .then(response => response.json())
            .then(data => {
                branchSelect.innerHTML = '';
                if (data.branches.length > 0) {
                    data.branches.forEach(branch => {
                        branchSelect.innerHTML += `<option value="${branch.id}">${branch.name}</option>`;
                    });
                } else {
                    branchSelect.innerHTML = '<option value="">No branches available</option>';
                }
            })
            .catch(error => {
                branchSelect.innerHTML = '<option value="">Failed to load branches</option>';
                console.error('Error fetching branches:', error);
            });
    });
});
</script>

@endsection
