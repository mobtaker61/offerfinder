@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add New Offer</h2>

    <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Column -->
            <div class="col-6">
                <!-- Master Dropdown: Select Market -->
                <div class="mb-3">
                    <label class="form-label">Select Market</label>
                    <select id="marketSelect" name="market_id" class="form-control" required>
                        <option value="">Select Market</option>
                        @foreach ($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Child Dropdown: Select Branch -->
                <div class="mb-3">
                    <label class="form-label">Select Branches</label>
                    <select name="branch_ids[]" id="branchSelect" class="form-control" multiple required>
                        <option value="">First, select a market...</option>
                    </select>
                    <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple branches</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-6">
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
                    <input type="file" name="offer_images[]" id="offerImages" class="form-control" multiple>
                </div>
                <div id="galleryPreview" class="row"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Offer</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let marketSelect = document.getElementById('marketSelect');
    let branchSelect = document.getElementById('branchSelect');
    let offerImages = document.getElementById('offerImages');
    let galleryPreview = document.getElementById('galleryPreview');

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

    offerImages.addEventListener('change', function() {
        galleryPreview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('col-2', 'mb-3');
                galleryPreview.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });
});
</script>

@endsection
