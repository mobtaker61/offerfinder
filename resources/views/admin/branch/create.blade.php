@extends('layouts.admin')

@section('title', 'Create Branch')

@push('styles')
<style>
    #map {
        height: 300px;
        width: 100%;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    .leaflet-container {
        z-index: 1;
    }
    .contact-profile-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .branch-details, .contact-details {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Create Branch</h1>
    <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.branches.store') }}" method="POST" id="branchForm" onsubmit="return validateForm(event)">
    @csrf
    <div class="row">
        <!-- Left Column - Branch Details -->
        <div class="col-md-5">
            <div class="branch-details">
                <h4 class="mb-4">Branch Details</h4>
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="market_id" class="form-label">Market</label>
                        <select class="form-select @error('market_id') is-invalid @enderror" id="market_id" name="market_id" required>
                            <option value="">Select Market</option>
                            @foreach($markets as $market)
                                <option value="{{ $market->id }}" {{ old('market_id') == $market->id ? 'selected' : '' }}>
                                    {{ $market->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('market_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Location</label>
                        <div id="map" 
                            style="height: 300px; width: 100%; margin-bottom: 10px;"
                            data-lat="{{ old('latitude', '25.2048') }}"
                            data-lng="{{ old('longitude', '55.2708') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" step="any" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Latitude" readonly value="{{ old('latitude') }}" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="number" step="any" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Longitude" readonly value="{{ old('longitude') }}" required>
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
                            <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
            <div class="contact-details">
                <h4 class="mb-4">Contact Details</h4>
                <div id="contactProfiles">
                    @if(old('contact_profiles'))
                        @foreach(old('contact_profiles') as $index => $profile)
                            <div class="contact-profile-item">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <select class="form-select" name="contact_profiles[{{ $index }}][type]" required>
                                            <option value="">Select Type</option>
                                            @foreach(['phone', 'cell', 'whatsapp', 'email'] as $type)
                                                <option value="{{ $type }}" {{ $profile['type'] == $type ? 'selected' : '' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="contact_profiles[{{ $index }}][value]" value="{{ $profile['value'] }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="contact_profiles[{{ $index }}][is_primary]" id="primary_{{ $index }}" value="1" {{ isset($profile['is_primary']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="primary_{{ $index }}">Primary</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.contact-profile-item').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="contact-profile-item">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <select class="form-select" name="contact_profiles[0][type]" required>
                                        <option value="">Select Type</option>
                                        @foreach(['phone', 'cell', 'whatsapp', 'email'] as $type)
                                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="contact_profiles[0][value]" placeholder="Value" required>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="contact_profiles[0][is_primary]" id="primary_0" value="1">
                                        <label class="form-check-label" for="primary_0">Primary</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.contact-profile-item').remove()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addContactProfile()">
                    <i class="fas fa-plus"></i> Add Contact
                </button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Create Branch
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
    window.onload = function() {
        setTimeout(initMap, 100);
    };

    function initMap() {
        const mapElement = document.getElementById('map');
        const initialLat = parseFloat(mapElement.dataset.lat);
        const initialLng = parseFloat(mapElement.dataset.lng);
        const initialCenter = {
            lat: initialLat,
            lng: initialLng
        };

        map = new google.maps.Map(mapElement, {
            zoom: 12,
            center: initialCenter,
            mapTypeId: 'roadmap'
        });

        // Add marker
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: initialCenter
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
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="contact_profiles[${index}][type]" required>
                        <option value="">Select Type</option>
                        ${contactTypes.map(type => `<option value="${type}">${type.charAt(0).toUpperCase() + type.slice(1)}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="contact_profiles[${index}][value]" placeholder="Value" required>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="contact_profiles[${index}][is_primary]" id="primary_${index}" value="1">
                        <label class="form-check-label" for="primary_${index}">Primary</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.contact-profile-item').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(div);
    }

    // Form validation
    function validateForm(event) {
        console.log('Form validation started');
        
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

        return true;
    }

    // Add form submit event listener
    document.getElementById('branchForm').addEventListener('submit', function(event) {
        console.log('Form submit event triggered');
    });
</script>
@endpush
