@extends('layouts.admin')

@section('title', 'Edit District')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit District</h1>
        <a href="{{ route('admin.districts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Districts
        </a>
    </div>

    <form action="{{ route('admin.districts.update', $district) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">District Name</label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name', $district->name) }}"
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
                        value="{{ old('local_name', $district->local_name) }}">
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
                        <option value="{{ $emirate->id }}"
                            {{ old('emirate_id', $district->emirate_id) == $emirate->id ? 'selected' : '' }}>
                            {{ $emirate->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('emirate_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        id="description"
                        name="description"
                        rows="3">{{ old('description', $district->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox"
                            class="form-check-input @error('is_active') is-invalid @enderror"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $district->is_active) ? 'checked' : '' }}>
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
                        data-lat="{{ $district->latitude ?? '25.2048' }}"
                        data-lng="{{ $district->longitude ?? '55.2708' }}">
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
                    <textarea name="boundary_coordinates" class="form-control @error('boundary_coordinates') is-invalid @enderror" rows="3">{{ old('boundary_coordinates', json_encode($district->boundary_coordinates, JSON_PRETTY_PRINT)) }}</textarea>
                    @error('boundary_coordinates')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Enter valid JSON array of coordinates</small>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update District
            </button>
        </div>
    </form>
</div>

@push('scripts')
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
            zoom: 12,
            center: initialCenter,
            mapTypeId: 'roadmap'
        });

        // Add search box
        const input = document.createElement('input');
        input.className = 'form-control';
        input.type = 'text';
        input.placeholder = 'Search for a location...';
        input.style.marginBottom = '10px';
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
</script>
@endpush
@endsection