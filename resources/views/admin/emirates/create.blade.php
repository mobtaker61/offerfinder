@extends('layouts.admin')

@section('title', 'Create New Emirate')

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
                <h1 class="h3 mb-0 text-gray-800">Create Emirate</h1>
                <a href="{{ route('admin.emirates.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Emirates
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.emirates.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" 
                                name="name" 
                                id="name"
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="local_name" class="form-label">Local Name</label>
                            <input type="text" 
                                name="local_name" 
                                id="local_name"
                                class="form-control @error('local_name') is-invalid @enderror"
                                value="{{ old('local_name') }}">
                            @error('local_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                    type="checkbox" 
                                    name="is_active" 
                                    id="is_active" 
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
                                    <input type="number" 
                                        step="any" 
                                        name="latitude" 
                                        id="latitude" 
                                        class="form-control @error('latitude') is-invalid @enderror" 
                                        placeholder="Latitude" 
                                        readonly>
                                    @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" 
                                        step="any" 
                                        name="longitude" 
                                        id="longitude" 
                                        class="form-control @error('longitude') is-invalid @enderror" 
                                        placeholder="Longitude" 
                                        readonly>
                                    @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Boundary Coordinates (JSON)</label>
                            <textarea name="boundary_coordinates" 
                                class="form-control @error('boundary_coordinates') is-invalid @enderror" 
                                rows="3">{{ old('boundary_coordinates') }}</textarea>
                            @error('boundary_coordinates')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter valid JSON array of coordinates</small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Emirate
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

    function initMap() {
        const mapElement = document.getElementById('map');
        const initialLat = parseFloat(mapElement.dataset.lat);
        const initialLng = parseFloat(mapElement.dataset.lng);
        const initialCenter = {
            lat: initialLat,
            lng: initialLng
        };

        map = new google.maps.Map(mapElement, {
            zoom: 7,
            center: initialCenter,
            mapTypeId: 'terrain'
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
            map.setZoom(12);
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
</script>
@endsection