@extends('layouts.admin')

@section('title', 'Edit Branch')

@push('styles')
<style>
    #map {
        height: 300px;
        width: 100%;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
        border-radius: 8px;
        overflow: hidden;
    }

    .leaflet-container {
        z-index: 1;
    }

    .contact-profile-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .contact-profile-item:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .branch-details,
    .contact-details {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        font-weight: 500;
    }

    .required::after {
        content: " *";
        color: red;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Branch</h1>
    <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <h5 class="alert-heading">Please fix the following errors:</h5>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.branches.update', $branch) }}" method="POST" id="branchForm" onsubmit="return validateForm(event)">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-5">
            <div class="branch-details">
                <h4 class="mb-4">Branch Details</h4>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="market_id" class="form-label required">Market</label>
                        <select class="form-select @error('market_id') is-invalid @enderror" id="market_id" name="market_id" required>
                            <option value="">Select Market</option>
                            @foreach($markets as $market)
                            <option value="{{ $market->id }}" {{ old('market_id', $branch->market_id) == $market->id ? 'selected' : '' }}>
                                {{ $market->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('market_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="name" class="form-label required">Branch Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $branch->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $branch->address) }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label required">Location</label>
                        <div id="map"
                            data-lat="{{ old('latitude', $branch->latitude ?? '25.2048') }}"
                            data-lng="{{ old('longitude', $branch->longitude ?? '55.2708') }}">
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <input type="number" step="any" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Latitude" readonly value="{{ old('latitude', $branch->latitude) }}" required>
                                @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="number" step="any" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Longitude" readonly value="{{ old('longitude', $branch->longitude) }}" required>
                                @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-info-circle"></i> Click on the map to select the branch location
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                            @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Contact Details -->
        <div class="col-md-7">
                <div id="contactProfiles">
                    <h4 class="mb-4">Contact Details</h4>
                    @if(old('contact_profiles'))
                    @foreach(old('contact_profiles') as $index => $profile)
                    <div class="contact-profile-item">
                        <div class="row g-2 mb-2">
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="removeContactProfile(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select @error('contact_profiles.' . $index . '.type') is-invalid @enderror" name="contact_profiles[{{ $index }}][type]" required>
                                    <option value="">Select Type</option>
                                    @foreach(['phone', 'cell', 'whatsapp', 'email'] as $type)
                                    <option value="{{ $type }}" {{ $profile['type'] == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('contact_profiles.' . $index . '.type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control @error('contact_profiles.' . $index . '.value') is-invalid @enderror" name="contact_profiles[{{ $index }}][value]" value="{{ $profile['value'] }}" required>
                                @error('contact_profiles.' . $index . '.value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" name="contact_profiles[{{ $index }}][is_primary]" id="primary_{{ $index }}" value="1" {{ isset($profile['is_primary']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="primary_{{ $index }}">Primary</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    @foreach($branch->contactProfiles as $index => $profile)
                    <div class="contact-profile-item">
                        <div class="row g-2 mb-2">
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="removeContactProfile(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="contact_profiles[{{ $index }}][type]" required>
                                    <option value="">Select Type</option>
                                    @foreach(['phone', 'cell', 'whatsapp', 'email'] as $type)
                                    <option value="{{ $type }}" {{ $profile->type == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="contact_profiles[{{ $index }}][value]" value="{{ $profile->value }}" required>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" name="contact_profiles[{{ $index }}][is_primary]" id="primary_{{ $index }}" value="1" {{ $profile->is_primary ? 'checked' : '' }}>
                                    <label class="form-check-label" for="primary_{{ $index }}">Primary</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addContactProfile()">
                    <i class="fas fa-plus"></i> Add Contact
                </button>

                <div class="mt-4">
                    <h4>Coverage Area</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emirate_id">Emirate <span class="text-danger">*</span></label>
                                <select class="form-control @error('emirate_id') is-invalid @enderror" id="emirate_id" name="emirate_id" required>
                                    <option value="">Select Emirate</option>
                                    @foreach($emirates as $emirate)
                                    <option value="{{ $emirate->id }}" {{ old('emirate_id', $branch->neighbours->first()->district->emirate_id ?? '') == $emirate->id ? 'selected' : '' }}>
                                        {{ $emirate->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('emirate_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district_id">District <span class="text-danger">*</span></label>
                                <select class="form-control @error('district_id') is-invalid @enderror" id="district_id" name="district_id" required>
                                    <option value="">Select District</option>
                                </select>
                                @error('district_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="neighbours">Neighbours <span class="text-danger">*</span></label>
                        <select class="form-control @error('neighbours') is-invalid @enderror" id="neighbours" size="15" name="neighbours[]" multiple required>
                            @foreach($branch->neighbours as $neighbour)
                            <option value="{{ $neighbour->id }}" selected>{{ $neighbour->name }}</option>
                            @endforeach
                        </select>
                        @error('neighbours')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Branch
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
    let map;
    let marker;
    const contactTypes = ['phone', 'cell', 'whatsapp', 'email'];

    // Initialize map when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for Google Maps to be loaded
        if (typeof google !== 'undefined' && google.maps) {
            initMap();
        } else {
            // If Google Maps is not loaded yet, wait for it
            window.initMap = initMap;
        }

        // Initialize Select2 for neighbours
        $('#neighbours').select2({
            placeholder: 'Select Neighbours',
            allowClear: true
        });

        // Handle emirate change
        $('#emirate_id').change(function() {
            var emirateId = $(this).val();
            var districtSelect = $('#district_id');
            var neighboursSelect = $('#neighbours');

            districtSelect.empty().append('<option value="">Select District</option>');
            neighboursSelect.empty();

            if (emirateId) {
                $.get(`{{ route('districts.get', '') }}/${emirateId}`, function(districts) {
                    districts.forEach(function(district) {
                        districtSelect.append(new Option(district.name, district.id));
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching districts:', textStatus, errorThrown);
                    alert('Error loading districts. Please try again.');
                });
            }
        });

        // Handle district change
        $('#district_id').change(function() {
            var districtId = $(this).val();
            var neighboursSelect = $('#neighbours');

            neighboursSelect.empty();

            if (districtId) {
                $.get(`{{ route('neighbours.get', '') }}/${districtId}`, function(neighbours) {
                    neighbours.forEach(function(neighbour) {
                        neighboursSelect.append(new Option(neighbour.name, neighbour.id));
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching neighbours:', textStatus, errorThrown);
                    alert('Error loading neighbours. Please try again.');
                });
            }
        });

        // Trigger emirate change if it has a value
        if ($('#emirate_id').val()) {
            $('#emirate_id').trigger('change');
        }
    });

    function initMap() {
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.error('Map element not found');
            return;
        }

        const initialLat = parseFloat(mapElement.dataset.lat);
        const initialLng = parseFloat(mapElement.dataset.lng);
        const initialCenter = {
            lat: initialLat,
            lng: initialLng
        };

        // Set a minimum size for the map container
        mapElement.style.minHeight = '300px';
        mapElement.style.width = '100%';

        map = new google.maps.Map(mapElement, {
            zoom: 12,
            center: initialCenter,
            mapTypeId: 'roadmap',
            mapTypeControl: true,
            streetViewControl: false,
            fullscreenControl: true
        });

        // Add marker
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: initialCenter,
            title: 'Branch Location'
        });

        // Set initial coordinates
        document.getElementById('latitude').value = initialLat;
        document.getElementById('longitude').value = initialLng;

        // Update coordinates when marker is dragged
        marker.addListener('dragend', function() {
            updateCoordinates(marker.getPosition());
        });

        // Update coordinates when map is clicked
        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            updateCoordinates(e.latLng);
        });

        // Trigger a resize event to ensure the map displays correctly
        google.maps.event.trigger(map, 'resize');
    }

    function updateCoordinates(position) {
        document.getElementById('latitude').value = position.lat();
        document.getElementById('longitude').value = position.lng();
    }

    // Add contact profile
    function addContactProfile() {
        const container = document.getElementById('contactProfiles');
        const index = container.children.length;

        const div = document.createElement('div');
        div.className = 'contact-profile-item';
        div.innerHTML = `
            <div class="row g-2 mb-2">
            <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="removeContactProfile(this)">
                <i class="fas fa-trash"></i>
            </button>
            </div>
            <div class="col-md-4">
                    <select class="form-select" name="contact_profiles[${index}][type]" required>
                        <option value="">Select Type</option>
                        ${contactTypes.map(type => `<option value="${type}">${type.charAt(0).toUpperCase() + type.slice(1)}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="contact_profiles[${index}][value]" placeholder="Enter value" required>
                </div>
                <div class="col-md-2">
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="contact_profiles[${index}][is_primary]" id="primary_${index}" value="1">
                        <label class="form-check-label" for="primary_${index}">Primary</label>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    }

    // Remove contact profile
    function removeContactProfile(button) {
        const container = document.getElementById('contactProfiles');
        if (container.children.length > 1) {
            button.closest('.contact-profile-item').remove();
        } else {
            alert('At least one contact profile is required');
        }
    }

    // Update form validation
    function validateForm(event) {
        if ($('#neighbours').val() === null) {
            alert('Please select at least one neighbour');
            event.preventDefault();
            return false;
        }

        const contactProfiles = document.querySelectorAll('.contact-profile-item');
        if (contactProfiles.length === 0) {
            alert('Please add at least one contact profile');
            event.preventDefault();
            return false;
        }

        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        if (!latitude || !longitude) {
            alert('Please select a location on the map');
            event.preventDefault();
            return false;
        }

        // Log form data before submission
        const formData = new FormData(event.target);
        const formDataObj = {};
        formData.forEach((value, key) => {
            formDataObj[key] = value;
        });
        console.log('Form data being submitted:', formDataObj);

        // If all validations pass, allow the form to submit
        return true;
    }
</script>
@endpush