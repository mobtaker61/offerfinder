@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add New Offer</h2>

    <form id="offerForm" action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="MAX_FILE_SIZE" value="{{ config('app.max_upload_size', 67108864) }}" />

        <div class="row">
            <!-- Left Column -->
            <div class="col-6">
                <!-- Market Selection -->
                <div class="mb-3">
                    <label class="form-label">Select Market</label>
                    <select id="marketSelect" name="market_id" class="form-control" required>
                        <option value="">Select Market</option>
                        @foreach ($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Branch Selection -->
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
                    <label class="form-label">Cover Image (Max: 10MB)</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                    <small class="text-muted">Supported formats: JPEG, PNG, JPG, GIF. Maximum size: 10MB</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Offer PDF (Max: 20MB)</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf">
                    <small class="text-muted">Maximum size: 20MB</small>
                </div>

                <!-- Offer Image Gallery Upload -->
                <div class="mb-3">
                    <label class="form-label">Offer Gallery Images (Max: 10MB each)</label>
                    <input type="file" name="offer_images[]" id="offerImages" class="form-control" multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                    <small class="text-muted">You can select multiple images. Each image maximum size: 10MB</small>
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
            if (file.size > 10 * 1024 * 1024) {
                toastr.error(`File ${file.name} is larger than 10MB`);
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
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        
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
                toastr.success(data.message || 'Offer created successfully');
                setTimeout(() => {
                    window.location.href = "{{ route('admin.offers.index') }}";
                }, 1000); // Wait for 1 second to show the success message
            } else {
                toastr.error(data.message || 'Error creating offer');
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
                toastr.error(error.message || 'An error occurred while creating the offer');
            }
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    });
});
</script>

@endsection
