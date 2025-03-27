@extends('layouts.admin')

@section('title', 'Branches')

@push('styles')
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info load-contacts-btn" data-branch-id="{{ $branch->id }}" data-branch-name="{{ $branch->name }}" title="Contacts">
                                    <i class="fas fa-address-book"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success load-location-btn" data-branch-id="{{ $branch->id }}" data-branch-name="{{ $branch->name }}" data-lat="{{ $branch->latitude }}" data-lng="{{ $branch->longitude }}" title="Location">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning load-areas-btn" data-branch-id="{{ $branch->id }}" data-branch-name="{{ $branch->name }}" title="Areas">
                                    <i class="fas fa-map"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary load-admins-btn" data-branch-id="{{ $branch->id }}" data-branch-name="{{ $branch->name }}" title="Admins">
                                    <i class="fas fa-users"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this branch?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No branches found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Branch Admins Modal -->
<div class="modal fade" id="adminsModal" tabindex="-1" aria-labelledby="adminsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminsModalLabel">Branch Admins</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-5" id="modalLoader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading admin data...</p>
                </div>
                <div id="modalContent" style="display: none;">
                    <div class="mb-3">
                        <label for="newAdmin" class="form-label">Add New Admin</label>
                        <div class="input-group">
                            <select class="form-select" id="newAdmin">
                                <option value="">Select User</option>
                            </select>
                            <button class="btn btn-primary" type="button" id="assignAdminBtn">
                                Assign
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="adminsTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Branch Contacts Modal -->
<div class="modal fade" id="contactsModal" tabindex="-1" aria-labelledby="contactsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactsModalLabel">Contact Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-5" id="contactsLoader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading contact data...</p>
                </div>
                <div id="contactsContent" style="display: none;">
                    <div class="list-group">
                        <!-- Contact items will be inserted here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Branch Location Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel">Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Latitude:</strong> <span id="branchLatitude"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Longitude:</strong> <span id="branchLongitude"></span>
                    </div>
                </div>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Branch Areas Modal -->
<div class="modal fade" id="areasModal" tabindex="-1" aria-labelledby="areasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="areasModalLabel">Coverage Areas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-5" id="areasLoader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading areas data...</p>
                </div>
                <div id="areasContent" style="display: none;">
                    <div class="list-group">
                        <!-- Area items will be inserted here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
    // Initialize modals using jQuery
    const adminsModal = $('#adminsModal');
    const contactsModal = $('#contactsModal');
    const locationModal = $('#locationModal');
    const areasModal = $('#areasModal');
    
    let currentBranchId = null;
    let currentBranchName = null;
    let currentMap = null;

    // Admin button click handler
    $(document).on('click', '.load-admins-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        currentBranchId = $(this).data('branch-id');
        currentBranchName = $(this).data('branch-name');
        
        $('#adminsModalLabel').text('Branch Admins - ' + currentBranchName);
        $('#modalLoader').show();
        $('#modalContent').hide();
        
        adminsModal.modal('show');
        loadBranchAdmins(currentBranchId);
    });

    // Contacts button click handler
    $(document).on('click', '.load-contacts-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        currentBranchId = $(this).data('branch-id');
        currentBranchName = $(this).data('branch-name');
        
        $('#contactsModalLabel').text('Contact Details - ' + currentBranchName);
        $('#contactsLoader').show();
        $('#contactsContent').hide();
        
        contactsModal.modal('show');
        loadBranchContacts(currentBranchId);
    });

    // Location button click handler
    $(document).on('click', '.load-location-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        currentBranchId = $(this).data('branch-id');
        currentBranchName = $(this).data('branch-name');
        const lat = parseFloat($(this).data('lat'));
        const lng = parseFloat($(this).data('lng'));
        
        $('#locationModalLabel').text('Location - ' + currentBranchName);
        $('#branchLatitude').text(lat);
        $('#branchLongitude').text(lng);
        
        locationModal.modal('show');
        initMap(lat, lng, currentBranchName);
    });

    // Areas button click handler
    $(document).on('click', '.load-areas-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        currentBranchId = $(this).data('branch-id');
        currentBranchName = $(this).data('branch-name');
        
        $('#areasModalLabel').text('Coverage Areas - ' + currentBranchName);
        $('#areasLoader').show();
        $('#areasContent').hide();
        
        areasModal.modal('show');
        loadBranchAreas(currentBranchId);
    });

    // Function to load branch admins
    function loadBranchAdmins(branchId) {
        fetch(`/admin/branches/${branchId}/get-admins`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selectElement = $('#newAdmin');
                selectElement.empty().append('<option value="">Select User</option>');
                
                data.availableAdmins.forEach(admin => {
                    selectElement.append(`<option value="${admin.id}">${admin.name} (${admin.email})</option>`);
                });
                
                const tableBody = $('#adminsTable tbody');
                tableBody.empty();
                
                if (data.currentAdmins.length === 0) {
                    tableBody.append('<tr><td colspan="4" class="text-center">No admins assigned to this branch</td></tr>');
                } else {
                    data.currentAdmins.forEach(admin => {
                        const statusBadge = admin.is_active 
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>';
                            
                        tableBody.append(`
                            <tr>
                                <td>${admin.name}</td>
                                <td>${admin.email}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-admin-btn" data-user-id="${admin.id}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
                
                $('#modalLoader').hide();
                $('#modalContent').show();
                
                $('#assignAdminBtn').off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    assignAdmin(currentBranchId);
                });
                
                tableBody.off('click').on('click', '.remove-admin-btn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const userId = $(this).data('user-id');
                    removeAdmin(currentBranchId, userId);
                });
            } else {
                alert(data.message || 'Failed to load admin data');
                adminsModal.modal('hide');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load admin data');
            adminsModal.modal('hide');
        });
    }

    // Function to load branch contacts
    function loadBranchContacts(branchId) {
        fetch(`/admin/branches/${branchId}/contacts`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const contactsList = $('#contactsContent .list-group');
                contactsList.empty();
                
                data.contacts.forEach(contact => {
                    let icon = '';
                    switch(contact.type) {
                        case 'phone':
                            icon = '<i class="fas fa-phone-alt text-primary me-2"></i>';
                            break;
                        case 'cell':
                            icon = '<i class="fas fa-mobile-alt text-success me-2"></i>';
                            break;
                        case 'whatsapp':
                            icon = '<i class="fab fa-whatsapp text-success me-2"></i>';
                            break;
                        case 'email':
                            icon = '<i class="fas fa-envelope text-danger me-2"></i>';
                            break;
                    }
                    
                    contactsList.append(`
                        <div class="list-group-item d-flex align-items-center">
                            ${icon}
                            <span>${contact.value}</span>
                            ${contact.is_primary ? '<span class="badge bg-primary ms-2">Primary</span>' : ''}
                        </div>
                    `);
                });
                
                $('#contactsLoader').hide();
                $('#contactsContent').show();
            } else {
                alert(data.message || 'Failed to load contact data');
                contactsModal.modal('hide');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load contact data');
            contactsModal.modal('hide');
        });
    }

    // Function to load branch areas
    function loadBranchAreas(branchId) {
        fetch(`/admin/branches/${branchId}/areas`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const areasList = $('#areasContent .list-group');
                areasList.empty();
                
                Object.entries(data.areas).forEach(([emirateName, districts]) => {
                    areasList.append(`
                        <div class="list-group-item">
                            <h6 class="mb-2">${emirateName}</h6>
                            <div class="ms-3">
                                ${Object.entries(districts).map(([districtName, neighbours]) => `
                                    <div class="mb-2">
                                        <strong>${districtName}:</strong>
                                        <div class="ms-3">
                                            ${neighbours.map(neighbour => `<div>${neighbour}</div>`).join('')}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `);
                });
                
                $('#areasLoader').hide();
                $('#areasContent').show();
            } else {
                alert(data.message || 'Failed to load areas data');
                areasModal.modal('hide');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load areas data');
            areasModal.modal('hide');
        });
    }

    // Function to assign an admin
    function assignAdmin(branchId) {
        const userId = $('#newAdmin').val();
        
        if (!userId) {
            alert('Please select a user');
            return;
        }
        
        fetch(`/admin/branches/${branchId}/assign-admin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadBranchAdmins(branchId);
            } else {
                alert(data.message || 'Failed to assign admin');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to assign admin');
        });
    }

    // Function to remove an admin
    function removeAdmin(branchId, userId) {
        if (!confirm('Are you sure you want to remove this admin?')) {
            return;
        }
        
        fetch(`/admin/branches/${branchId}/remove-admin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadBranchAdmins(branchId);
            } else {
                alert(data.message || 'Failed to remove admin');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to remove admin');
        });
    }

    // Function to initialize map
    function initMap(lat, lng, name) {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        if (currentMap) {
            currentMap = null;
        }

        const position = { lat, lng };
        currentMap = new google.maps.Map(mapElement, {
            zoom: 15,
            center: position,
            mapTypeId: 'roadmap',
            mapTypeControl: true,
            fullscreenControl: true,
            streetViewControl: true,
            zoomControl: true
        });

        new google.maps.Marker({
            position: position,
            map: currentMap,
            title: name,
            animation: google.maps.Animation.DROP
        });

        google.maps.event.trigger(currentMap, 'resize');
    }

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
        order: [[0, 'desc']],
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
                targets: -1,
                orderable: false,
                searchable: false
            }
        ],
        processing: true,
        serverSide: false,
        stateSave: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
    });

    // Create market filter dropdown
    const marketFilter = $('<select class="form-select form-select-sm market-filter" style="width: 200px;"><option value="">All Markets</option>@foreach($markets as $market)<option value="{{ $market->name }}">{{ $market->name }}</option>@endforeach</select>');

    // Insert market filter into the controls row
    $('.dt-controls-row').append(marketFilter);

    // Market filter functionality
    marketFilter.on('change', function() {
        const selectedMarket = $(this).val();
        branchesTable.column(2).search(selectedMarket).draw();
    });
});
</script>
@endsection
