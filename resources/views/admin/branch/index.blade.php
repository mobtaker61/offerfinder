@extends('layouts.admin')

@section('title', 'Branches')

@push('styles')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Modal styles */
    .modal {
        z-index: 1055;
    }
    .modal-backdrop {
        z-index: 1054;
    }
    .modal-dialog {
        z-index: 1056;
    }
    .modal-content {
        position: relative;
        z-index: 1057;
    }
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Branches</h1>
        <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Branch
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm">
        <div class="table-responsive">
            <table id="branchesTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Market</th>
                        <th>Status</th>
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#contactsModal{{ $branch->id }}">
                                    <i class="fas fa-address-book"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#locationModal{{ $branch->id }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#areasModal{{ $branch->id }}">
                                    <i class="fas fa-map"></i>
                                </button>
                                <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this branch?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No branches found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Contacts Modals -->
@foreach($branches as $branch)
<div class="modal fade" id="contactsModal{{ $branch->id }}" tabindex="-1" aria-labelledby="contactsModalLabel{{ $branch->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactsModalLabel{{ $branch->id }}">Contact Details - {{ $branch->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @foreach($branch->contactProfiles as $profile)
                        <div class="list-group-item d-flex align-items-center">
                            @switch($profile->type)
                                @case('phone')
                                    <i class="fas fa-phone-alt text-primary me-2" title="Phone"></i>
                                    @break
                                @case('cell')
                                    <i class="fas fa-mobile-alt text-success me-2" title="Cell"></i>
                                    @break
                                @case('whatsapp')
                                    <i class="fab fa-whatsapp text-success me-2" title="WhatsApp"></i>
                                    @break
                                @case('email')
                                    <i class="fas fa-envelope text-danger me-2" title="Email"></i>
                                    @break
                            @endswitch
                            <span>{{ $profile->value }}</span>
                            @if($profile->is_primary)
                                <span class="badge bg-primary ms-2">Primary</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Location Modal -->
<div class="modal fade" id="locationModal{{ $branch->id }}" 
    tabindex="-1" 
    aria-labelledby="locationModalLabel{{ $branch->id }}" 
    aria-hidden="true"
    data-branch-id="{{ $branch->id }}"
    data-lat="{{ $branch->latitude }}"
    data-lng="{{ $branch->longitude }}"
    data-name="{{ $branch->name }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel{{ $branch->id }}">Location - {{ $branch->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map{{ $branch->id }}" style="height: 400px; width: 100%;"></div>
                <div class="mt-3">
                    <p><strong>Address:</strong> {{ $branch->address }}</p>
                    <p><strong>Latitude:</strong> {{ $branch->latitude }}</p>
                    <p><strong>Longitude:</strong> {{ $branch->longitude }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Areas Modal -->
<div class="modal fade" id="areasModal{{ $branch->id }}" tabindex="-1" aria-labelledby="areasModalLabel{{ $branch->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="areasModalLabel{{ $branch->id }}">Coverage Areas - {{ $branch->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @foreach($branch->neighbours->groupBy('district.emirate.name') as $emirateName => $neighbours)
                        <div class="list-group-item">
                            <h6 class="mb-2">{{ $emirateName }}</h6>
                            <div class="ms-3">
                                @foreach($neighbours->groupBy('district.name') as $districtName => $districtNeighbours)
                                    <div class="mb-2">
                                        <strong>{{ $districtName }}:</strong>
                                        <div class="ms-3">
                                            @foreach($districtNeighbours as $neighbour)
                                                <div>{{ $neighbour->name }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
    $(document).ready(function() {
        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('#branchesTable')) {
            $('#branchesTable').DataTable().destroy();
        }

        // Create market filter dropdown
        const marketFilter = $('<select class="form-select form-select-sm market-filter" style="width: 200px;"><option value="">All Markets</option>@foreach($markets as $market)<option value="{{ $market->name }}">{{ $market->name }}</option>@endforeach</select>');

        // Initialize DataTable
        const branchesTable = $('#branchesTable').DataTable({
            dom: '<"dt-controls-row d-flex justify-content-between"<"dt-buttons"B><"market-filter"l><"dataTables_filter"f>>rtip',
            buttons: [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        'copy',
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ]
                }
            ],
            pageLength: 10,
            order: [[0, 'desc']], // Sort by ID descending
            language: {
                search: "",
                lengthMenu: "_MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_ branches",
                infoEmpty: "Showing 0 to 0 of 0 branches",
                infoFiltered: "(filtered from _MAX_ total branches)",
                zeroRecords: "No matching branches found",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            responsive: true,
            columnDefs: [
                {
                    targets: -1, // Actions column
                    orderable: false,
                    searchable: false
                }
            ],
            processing: true,
            serverSide: false,
            stateSave: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            drawCallback: function() {
                // Reinitialize any Bootstrap tooltips or popovers if needed
                $('[data-bs-toggle="tooltip"]').tooltip();
                $('[data-bs-toggle="popover"]').popover();
            }
        });

        // Insert market filter into the controls row
        $('.dt-controls-row').append(marketFilter);

        // Market filter functionality
        marketFilter.on('change', function() {
            const selectedMarket = $(this).val();
            branchesTable.column(2).search(selectedMarket).draw();
        });

        // Initialize maps when modals are shown
        document.querySelectorAll('[id^="locationModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                initMap(
                    this.dataset.branchId,
                    parseFloat(this.dataset.lat),
                    parseFloat(this.dataset.lng),
                    this.dataset.name
                );
            });
        });

        // Clean up modals when they're hidden
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                // Remove any existing map instances
                const mapId = this.querySelector('[id^="map"]')?.id;
                if (mapId) {
                    const mapElement = document.getElementById(mapId);
                    if (mapElement) {
                        mapElement.innerHTML = '';
                    }
                }
                // Remove the backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                // Remove the modal-open class from body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        });
    });

    function initMap(branchId, lat, lng, name) {
        const mapElement = document.getElementById('map' + branchId);
        if (!mapElement) return;

        const position = { lat, lng };
        const map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: position,
            mapTypeId: 'roadmap'
        });

        new google.maps.Marker({
            position: position,
            map: map,
            title: name
        });

        // Trigger a resize event to ensure the map displays correctly
        google.maps.event.trigger(map, 'resize');
    }
</script>
@endpush
