@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="card-title mb-4">Edit Emirate</h2>

    <form action="{{ route('admin.emirates.update', $emirate->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $emirate->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Local Name</label>
                    <input type="text" name="local_name" class="form-control @error('local_name') is-invalid @enderror"
                        value="{{ old('local_name', $emirate->local_name) }}">
                    @error('local_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $emirate->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <div id="map" style="height: 300px; width: 100%; margin-bottom: 10px;"
                        data-lat="{{ $emirate->latitude ?? '25.2048' }}"
                        data-lng="{{ $emirate->longitude ?? '55.2708' }}"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" step="any" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror"
                                value="{{ old('latitude', $emirate->latitude) }}" placeholder="Latitude" readonly>
                            @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="number" step="any" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror"
                                value="{{ old('longitude', $emirate->longitude) }}" placeholder="Longitude" readonly>
                            @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Boundary Coordinates (JSON)</label>
                    <textarea name="boundary_coordinates" class="form-control @error('boundary_coordinates') is-invalid @enderror"
                        rows="3">{{ old('boundary_coordinates', json_encode($emirate->boundary_coordinates, JSON_PRETTY_PRINT)) }}</textarea>
                    @error('boundary_coordinates')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Enter valid JSON array of coordinates</small>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Emirate
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    let map;
    let marker;

    function initMap() {
        const mapElement = document.getElementById('map');
        const lat = parseFloat(mapElement.dataset.lat);
        const lng = parseFloat(mapElement.dataset.lng);
        const center = {
            lat,
            lng
        };

        map = new google.maps.Map(mapElement, {
            zoom: 7,
            center: center,
            mapTypeId: 'terrain'
        });

        // Add click listener to map
        map.addListener('click', function(e) {
            placeMarker(e.latLng);
        });

        // Add search box
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Search location...';
        input.className = 'form-control mb-2';
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        const searchBox = new google.maps.places.SearchBox(input);
        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();
            if (places.length === 0) return;

            const place = places[0];
            if (!place.geometry || !place.geometry.location) return;

            map.setCenter(place.geometry.location);
            map.setZoom(12);
            placeMarker(place.geometry.location);
        });

        // Place initial marker if coordinates exist
        if (lat !== 25.2048 || lng !== 55.2708) {
            placeMarker(center);
        }
    }

    function placeMarker(latLng) {
        if (marker) {
            marker.setMap(null);
        }

        marker = new google.maps.Marker({
            position: latLng,
            map: map,
            draggable: true
        });

        // Update coordinates when marker is dragged
        marker.addListener('dragend', function() {
            updateCoordinates(marker.getPosition());
        });

        updateCoordinates(latLng);
    }

    function updateCoordinates(latLng) {
        document.getElementById('latitude').value = latLng.lat();
        document.getElementById('longitude').value = latLng.lng();
    }

    // Initialize map when the page loads
    window.onload = initMap;
</script>
@endpush
@endsection