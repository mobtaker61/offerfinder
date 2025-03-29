@extends('layouts.admin')

@section('title', 'Create New Neighbour')

@section('styles')
<style>
    /* Form specific styles */
    .form-label {
        font-weight: 500;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    /* Map styles */
    #map {
        border-radius: 4px;
        overflow: hidden;
    }

    .search-box {
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Create Neighbour</h1>
                <a href="{{ route('admin.neighbours.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Neighbours
                </a>
            </div>
        </div>
        <div class="card-body" data-districts='@json($districts)' data-old-district='{{ old('district_id') }}'>
            <form action="{{ route('admin.neighbours.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Neighbour Name</label>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="local_name" class="form-label">Local Name (Arabic)</label>
                            <input type="text"
                                class="form-control @error('local_name') is-invalid @enderror"
                                id="local_name"
                                name="local_name"
                                value="{{ old('local_name') }}">
                            @error('local_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="emirate_id" class="form-label">Emirate</label>
                            <select class="form-select @error('emirate_id') is-invalid @enderror"
                                id="emirate_id"
                                name="emirate_id"
                                required>
                                <option value="">Select an Emirate</option>
                                @foreach($emirates as $emirate)
                                <option value="{{ $emirate->id }}" {{ old('emirate_id') == $emirate->id ? 'selected' : '' }}>
                                    {{ $emirate->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('emirate_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="district_id" class="form-label">District</label>
                            <select class="form-select @error('district_id') is-invalid @enderror"
                                id="district_id"
                                name="district_id"
                                required>
                                <option value="">Select a District</option>
                            </select>
                            @error('district_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="info_link" class="form-label">Info Link</label>
                            <input type="url"
                                class="form-control @error('info_link') is-invalid @enderror"
                                id="info_link"
                                name="info_link"
                                value="{{ old('info_link') }}"
                                placeholder="https://">
                            @error('info_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox"
                                    class="form-check-input @error('is_active') is-invalid @enderror"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                                @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <div id="map"
                                style="height: 300px; width: 100%; margin-bottom: 10px;"
                                data-lat="{{ old('latitude', '25.2048') }}"
                                data-lng="{{ old('longitude', '55.2708') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" step="any" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Latitude" readonly>
                                    @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" step="any" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Longitude" readonly>
                                    @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Boundary Coordinates (JSON)</label>
                            <textarea name="boundary_coordinates" class="form-control @error('boundary_coordinates') is-invalid @enderror" rows="3">{{ old('boundary_coordinates') }}</textarea>
                            @error('boundary_coordinates')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter valid JSON array of coordinates</small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Neighbour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
    let map;
    let marker;
    const districts = JSON.parse(document.querySelector('.card-body').dataset.districts);

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

        // Add search box
        const input = document.createElement('input');
        input.className = 'form-control search-box';
        input.type = 'text';
        input.placeholder = 'Search for a location...';
        document.getElementById('map').parentNode.insertBefore(input, document.getElementById('map'));

        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

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

        // Update coordinates when place is selected
        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();
            if (places.length === 0) return;

            const place = places[0];
            if (!place.geometry || !place.geometry.location) return;

            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            updateCoordinates(place.geometry.location);
        });
    }

    function updateCoordinates(position) {
        document.getElementById('latitude').value = position.lat();
        document.getElementById('longitude').value = position.lng();
    }

    // Initialize map when the page loads
    window.onload = initMap;

    // Handle emirate selection
    document.getElementById('emirate_id').addEventListener('change', function() {
        const emirateId = this.value;
        const districtSelect = document.getElementById('district_id');
        const oldDistrictId = document.querySelector('.card-body').dataset.oldDistrict;

        // Clear current options
        districtSelect.innerHTML = '<option value="">Select a District</option>';

        if (emirateId) {
            // Filter districts by emirate
            const filteredDistricts = districts.filter(district => district.emirate_id == emirateId);

            // Add filtered districts
            filteredDistricts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.id;
                option.textContent = district.name;
                option.selected = district.id == oldDistrictId;
                districtSelect.appendChild(option);
            });
        }
    });

    // Trigger change event if emirate is pre-selected
    const emirateSelect = document.getElementById('emirate_id');
    if (emirateSelect.value) {
        emirateSelect.dispatchEvent(new Event('change'));
    }
</script>
@endsection