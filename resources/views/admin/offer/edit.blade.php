@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Offer</h2>

    <form id="offerForm" action="{{ route('admin.offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column -->
            <div class="col-6">
                <!-- Market Selection -->
                <div class="mb-3">
                    <label class="form-label">Select Market</label>
                    <select id="marketSelect" name="market_id" class="form-control" required>
                        <option value="">Select Market</option>
                        @foreach ($markets as $market)
                        <option value="{{ $market->id }}" {{ $offer->market_id == $market->id ? 'selected' : '' }}>{{ $market->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Branch Selection -->
                <div class="mb-3">
                    <label class="form-label">Select Branches</label>
                    <select name="branch_ids[]" id="branchSelect" class="form-control" multiple required>
                        @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ in_array($branch->id, $offer->branches->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple branches</small>
                </div>

                <!-- Category Selection -->
                <div class="mb-3">
                    <label class="form-label">Select Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $offer->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @foreach ($category->children as $child)
                        <option value="{{ $child->id }}" {{ $offer->category_id == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;- {{ $child->name }}</option>
                        @endforeach
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

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d') : '' }}" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d') : '' }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Offer</button>
            </div>

            <!-- Right Column -->
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">Cover Image (Max: 2MB)</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/jpeg,image/png,image/jpg">
                    @if ($offer->cover_image)
                    <img src="{{ asset('storage/' . $offer->cover_image) }}" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Offer PDF (Max: 5MB)</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf">
                    @if ($offer->pdf)
                    <a href="{{ asset('storage/' . $offer->pdf) }}" target="_blank" class="d-block mt-2">View PDF</a>
                    @endif
                </div>

                <!-- Offer Image Gallery Upload -->
                <div class="mb-3">
                    <label class="form-label">Offer Gallery Images (Max: 2MB each)</label>
                    <input type="file" name="offer_images[]" id="offerImages" class="form-control" multiple accept="image/jpeg,image/png,image/jpg">
                    <small class="text-muted">You can select multiple images. Each image maximum size: 2MB</small>
                    <div class="mt-2">
                        <label class="form-label">Current Images (Click to delete)</label>
                        <div class="row">
                            @foreach ($offer->images as $image)
                            <div class="col-2 mb-2">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail" style="object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 delete-image"
                                        data-image-id="{{ $image->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="galleryPreview" class="row">
                    <!-- Preview of new images will appear here -->
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let marketSelect = document.getElementById('marketSelect');
        let branchSelect = document.getElementById('branchSelect');
        let offerImages = document.getElementById('offerImages');
        let galleryPreview = document.getElementById('galleryPreview');
        let form = document.getElementById('offerForm');

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
                if (file.size > 2 * 1024 * 1024) {
                    toastr.error(`File ${file.name} is larger than 2MB`);
                    return;
                }
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('col-2', 'mb-3', 'img-thumbnail');
                    galleryPreview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted');

            let formData = new FormData(this);
            let totalSize = 0;

            // Calculate total size of all files
            formData.getAll('offer_images[]').forEach(file => totalSize += file.size);
            if (formData.get('cover_image')) totalSize += formData.get('cover_image').size;
            if (formData.get('pdf')) totalSize += formData.get('pdf').size;

            if (totalSize > 128 * 1024 * 1024) {
                toastr.error('Total file size exceeds 128MB limit');
                return;
            }

            // Show loading state
            let submitButton = form.querySelector('button[type="submit"]');
            let originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response:', data);
                    if (data.success) {
                        toastr.success(data.message || 'Offer updated successfully');
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.offers.index') }}";
                        }, 1000); // Wait for 1 second to show the success message
                    } else {
                        toastr.error(data.message || 'Error updating offer');
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.errors) {
                        Object.values(error.errors).forEach(messages => {
                            messages.forEach(message => toastr.error(message));
                        });
                    } else {
                        toastr.error(error.message || 'An error occurred while updating the offer');
                    }
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                });
        });

        // Handle image deletion
        document.querySelectorAll('.delete-image').forEach(button => {
            button.addEventListener('click', function() {
                if (!confirm('Are you sure you want to delete this image? This will also remove all products detected in this image.')) {
                    return;
                }

                const imageId = this.getAttribute('data-image-id');
                const imageContainer = this.closest('.col-md-3');

                // Show loading state
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                button.disabled = true;

                fetch(`{{ route('admin.offer-images.delete', '') }}/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Image deleted successfully');
                            imageContainer.remove(); // Remove the image container from the DOM
                        } else {
                            toastr.error(data.message || 'Error deleting image');
                            button.innerHTML = '<i class="fas fa-times"></i>';
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error(error.message || 'An error occurred while deleting the image');
                        button.innerHTML = '<i class="fas fa-times"></i>';
                        button.disabled = false;
                    });
            });
        });
    });
</script>

@endsection