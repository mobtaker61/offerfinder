@extends('layouts.admin')

@section('title', 'Branches')

@section('styles')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
<style>
    /* DataTables custom styles */
    .dataTables_wrapper .dt-buttons {
        margin-bottom: 0;
        margin-right: 1rem;
    }
    .dataTables_wrapper .dt-button {
        margin-right: 0.5rem;
    }
    .dataTables_wrapper .dataTables_length {
        margin-right: 1rem;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-right: 1rem;
    }
    .dataTables_wrapper .dataTables_filter input {
        width: 200px;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 0.85em;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.5em;
    }
    /* Custom row for controls */
    .dt-controls-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
    }
    .dt-controls-row .dt-buttons {
        margin-right: 1rem;
    }
    .dt-controls-row .d-flex {
        display: flex !important;
        align-items: center;
    }
    .dt-controls-row .market-filter {
        margin-right: 1rem;
    }
    .dt-controls-row .dataTables_length {
        margin-right: 1rem;
    }
    .dt-controls-row .dataTables_filter {
        margin-right: 0;
    }
    /* Map styles */
    #map {
        border-radius: 4px;
        overflow: hidden;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    /* Consistent table styles */
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin: 0 2px;
    }
    
    .btn-group .btn:first-child {
        margin-left: 0;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Branches</h1>
                <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Branch
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="branchesTable" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Market</th>
                            <th>Status</th>
                            <th>Manage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                        <tr>
                            <td>{{ $branch->id }}</td>
                            <td>{{ $branch->name }}</td>
                            <td>{{ $branch->market->name }}</td>
                            <td>
                                <span class="badge bg-{{ $branch->is_active ? 'success' : 'danger' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Manage buttons">
                                    <a href="{{ route('admin.offers.index', ['branch_id' => $branch->id]) }}" 
                                       class="btn btn-success btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Manage Offers">
                                        <i class="fas fa-tags"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-info btn-sm view-location-btn" 
                                            data-branch-id="{{ $branch->id }}"
                                            data-bs-toggle="tooltip"
                                            title="View Location">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action buttons">
                                    <a href="{{ route('admin.branches.edit', $branch->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit Branch">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.branches.destroy', $branch->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete Branch">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No branches found.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Location Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel">Branch Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden input to store branch data -->
<input type="hidden" id="branchesData" value="{{ json_encode($branches) }}">
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
$(document).ready(function() {
    // Initialize all tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize DataTable
    const table = $('#branchesTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 25,
        order: [[0, 'desc']],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            zeroRecords: "No matching records found",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Initialize map
    let map;
    let marker;

    function initMap(lat, lng, title) {
        const position = { lat: parseFloat(lat), lng: parseFloat(lng) };
        
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: position,
            mapTypeId: 'roadmap'
        });

        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title
        });
    }

    // Handle location view button click
    $(document).on('click', '.view-location-btn', function() {
        const branchId = $(this).data('branch-id');
        const branches = JSON.parse($('#branchesData').val());
        const branch = branches.find(b => b.id === parseInt(branchId));
        
        if (branch && branch.latitude && branch.longitude) {
            initMap(branch.latitude, branch.longitude, branch.name);
            const modal = new bootstrap.Modal(document.getElementById('locationModal'));
            modal.show();
        } else {
            alert('Location data not available for this branch.');
        }
    });

    // Clean up map when modal is hidden
    $('#locationModal').on('hidden.bs.modal', function () {
        if (map) {
            google.maps.event.clearInstanceListeners(map);
            map = null;
        }
        if (marker) {
            marker.setMap(null);
            marker = null;
        }
    });
});
</script>
@endsection
