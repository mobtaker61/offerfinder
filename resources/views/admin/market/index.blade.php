@extends('layouts.admin')

@section('title', 'Market List')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Market List</h1>
        <a href="{{ route('admin.markets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Market
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Local Name</th>
                    <th>Website</th>
                    <th>Apps</th>
                    <th>WhatsApp</th>
                    <th>Status</th>
                    <th>Plan</th>
                    <th>Manage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($markets as $market)
                <tr>
                    <td class="text-center">
                        @if($market->logo)
                        <img src="{{ asset('storage/' . $market->logo) }}" alt="{{ $market->name }}" width="100" class="img-thumbnail">
                        @else
                        <div class="text-muted">No Logo</div>
                        @endif
                    </td>
                    <td>{{ $market->name }}</td>
                    <td>{{ $market->local_name ?? '-' }}</td>
                    <td>
                        @if($market->website)
                        <a href="{{ $market->website }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-globe"></i> Visit Website
                        </a>
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            @if($market->android_app_link)
                            <a href="{{ $market->android_app_link }}" target="_blank" class="btn btn-sm btn-outline-success" title="Android App">
                                <i class="fab fa-android"></i>
                            </a>
                            @endif
                            @if($market->ios_app_link)
                            <a href="{{ $market->ios_app_link }}" target="_blank" class="btn btn-sm btn-outline-dark" title="iOS App">
                                <i class="fab fa-apple"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($market->whatsapp)
                        <a href="https://wa.me/{{ $market->whatsapp }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fab fa-whatsapp"></i> Contact
                        </a>
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input status-toggle" type="checkbox" data-market-id="{{ $market->id }}" {{ $market->is_active ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        @if($market->plan)
                            <span class="badge bg-success">{{ $market->plan->name }}</span>
                        @else
                            <span class="badge bg-secondary">No Plan</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.branches.index', ['market_id' => $market->id]) }}" class="btn btn-info btn-sm" title="Branches">
                                <i class="fas fa-store"></i>
                            </a>
                            <a href="{{ route('admin.offers.index', ['market_id' => $market->id]) }}" class="btn btn-success btn-sm" title="Offers">
                                <i class="fas fa-tag"></i>
                            </a>
                            <button type="button" class="btn btn-primary btn-sm load-admins-btn" data-market-id="{{ $market->id }}" data-market-name="{{ $market->name }}" title="Manage Admins">
                                <i class="fas fa-users"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.markets.edit', $market->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.markets.destroy', $market->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this market?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<!-- Single Dynamic Market Admins Modal -->
<div class="modal fade" id="adminsModal" tabindex="-1" aria-labelledby="adminsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminsModalLabel">Market Admins</h5>
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables to store current market info
    let currentMarketId = null;
    let currentMarketName = null;
    
    // Initialize the modal
    const adminsModal = new bootstrap.Modal(document.getElementById('adminsModal'));
    
    // Direct click handler for admin buttons
    document.querySelectorAll('.load-admins-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Get market info from data attributes
            currentMarketId = this.getAttribute('data-market-id');
            currentMarketName = this.getAttribute('data-market-name');
            
            // Update modal title
            document.getElementById('adminsModalLabel').textContent = 'Market Admins - ' + currentMarketName;
            
            // Reset the modal content
            document.getElementById('modalLoader').style.display = 'block';
            document.getElementById('modalContent').style.display = 'none';
            
            // Show the modal
            adminsModal.show();
            
            // Load admin data
            loadMarketAdmins(currentMarketId);
        });
    });
    
    // Function to load market admins
    function loadMarketAdmins(marketId) {
        fetch(`/admin/markets/${marketId}/get-admins`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate the select with available admins
                const selectElement = document.getElementById('newAdmin');
                selectElement.innerHTML = '<option value="">Select User</option>';
                
                data.availableAdmins.forEach(admin => {
                    selectElement.innerHTML += `<option value="${admin.id}">${admin.name} (${admin.email})</option>`;
                });
                
                // Populate the table with current admins
                const tableBody = document.querySelector('#adminsTable tbody');
                tableBody.innerHTML = '';
                
                if (data.currentAdmins.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center">No admins assigned to this market</td></tr>';
                } else {
                    data.currentAdmins.forEach(admin => {
                        const statusBadge = admin.is_active 
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>';
                            
                        tableBody.innerHTML += `
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
                        `;
                    });
                }
                
                // Hide loader, show content
                document.getElementById('modalLoader').style.display = 'none';
                document.getElementById('modalContent').style.display = 'block';
                
                // Set up assign button click handler
                document.getElementById('assignAdminBtn').addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    assignAdmin(currentMarketId);
                });
                
                // Set up remove buttons click handlers with event delegation
                tableBody.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-admin-btn')) {
                        e.preventDefault();
                        e.stopPropagation();
                        const userId = e.target.closest('.remove-admin-btn').dataset.userId;
                        removeAdmin(currentMarketId, userId);
                    }
                });
            } else {
                alert(data.message || 'Failed to load admin data');
                adminsModal.hide();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load admin data');
            adminsModal.hide();
        });
    }
    
    // Function to assign an admin
    function assignAdmin(marketId) {
        const userId = document.getElementById('newAdmin').value;
        
        if (!userId) {
            alert('Please select a user');
            return;
        }
        
        fetch(`/admin/markets/${marketId}/assign-admin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload admin data
                loadMarketAdmins(marketId);
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
    function removeAdmin(marketId, userId) {
        if (!confirm('Are you sure you want to remove this admin?')) {
            return;
        }
        
        fetch(`/admin/markets/${marketId}/remove-admin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload admin data
                loadMarketAdmins(marketId);
            } else {
                alert(data.message || 'Failed to remove admin');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to remove admin');
        });
    }
    
    // Status toggle functionality
    document.querySelectorAll('.status-toggle').forEach(switchElement => {
        switchElement.addEventListener('change', function() {
            const marketId = this.dataset.marketId;
            const isActive = this.checked;
            
            fetch(`/admin/markets/${marketId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    this.checked = !isActive;
                    alert(data.message || 'Failed to update market status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !isActive;
                alert('Failed to update market status');
            });
        });
    });
});
</script>
@endsection