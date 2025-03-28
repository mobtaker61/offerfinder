@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Setting Definitions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
        <li class="breadcrumb-item active">Setting Definitions</li>
    </ol>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Manage Setting Definitions</span>
                    <button type="button" class="btn btn-sm btn-primary modal-trigger" data-bs-target="#createSchemaModal">
                        <i class="fas fa-plus"></i> Add New Setting
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Label</th>
                                    <th>Group</th>
                                    <th>Data Type</th>
                                    <th>Required</th>
                                    <th>Display Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schemas as $schema)
                                    <tr>
                                        <td>{{ $schema->key }}</td>
                                        <td>{{ $schema->label }}</td>
                                        <td>{{ ucfirst($schema->group) }}</td>
                                        <td>{{ ucfirst($schema->data_type) }}</td>
                                        <td>
                                            <span class="badge {{ $schema->is_required ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $schema->is_required ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>{{ $schema->display_order }}</td>
                                        <td>
                                            <span class="badge {{ $schema->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $schema->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary edit-schema modal-trigger" 
                                                        data-bs-target="#editSchemaModal" 
                                                        data-schema="{{ json_encode($schema) }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.settings.schemas.destroy', $schema->id) }}" method="POST" class="d-inline ms-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this setting?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No setting definitions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Schema Modal -->
<div class="modal fade" id="createSchemaModal" tabindex="-1" aria-labelledby="createSchemaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.settings.schemas.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSchemaModalLabel">Add New Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="key" name="key" required 
                                   pattern="^[a-zA-Z0-9_\.]+$" 
                                   title="Only alphanumeric characters, underscores, and dots allowed">
                            <div class="form-text">Unique identifier for the setting (e.g., "app.currency", "site.logo")</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="label" class="form-label">Label <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="label" name="label" required>
                            <div class="form-text">Display name for the setting (e.g., "Application Currency", "Site Logo")</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="group" class="form-label">Group <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="group" name="group" required list="group-list">
                            <datalist id="group-list">
                                @foreach($groups as $group)
                                    <option value="{{ $group }}">
                                @endforeach
                                <option value="general">
                                <option value="appearance">
                                <option value="email">
                                <option value="payment">
                                <option value="social">
                                <option value="api">
                            </datalist>
                            <div class="form-text">Category to group related settings</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_type" class="form-label">Data Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="data_type" name="data_type" required>
                                <option value="string">String</option>
                                <option value="integer">Integer</option>
                                <option value="boolean">Boolean (Yes/No)</option>
                                <option value="float">Float/Decimal</option>
                                <option value="array">Array (JSON)</option>
                                <option value="object">Object (JSON)</option>
                                <option value="file">File</option>
                                <option value="image">Image</option>
                                <option value="email">Email</option>
                                <option value="url">URL</option>
                                <option value="text">Text (Multiline)</option>
                                <option value="select">Select (Dropdown)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3 select-options-container d-none">
                        <label for="options" class="form-label">Options <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="options" name="options" rows="3" placeholder='{"key1": "Value 1", "key2": "Value 2"}'></textarea>
                        <div class="form-text">JSON object for select options. Format: {"value": "label", "value2": "label2"}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                        <div class="form-text">Helpful text to explain the purpose of this setting</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="default_value" class="form-label">Default Value</label>
                        <input type="text" class="form-control" id="default_value" name="default_value">
                        <div class="form-text">Initial value for this setting</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0" min="0">
                            <div class="form-text">Settings are sorted by this value (ascending)</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="is_required" name="is_required" value="1">
                                <label class="form-check-label" for="is_required">Required</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Schema Modal -->
<div class="modal fade" id="editSchemaModal" tabindex="-1" aria-labelledby="editSchemaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editSchemaForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSchemaModalLabel">Edit Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_key" class="form-label">Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_key" name="key" required 
                                   pattern="^[a-zA-Z0-9_\.]+$" 
                                   title="Only alphanumeric characters, underscores, and dots allowed">
                            <div class="form-text">Unique identifier for the setting (e.g., "app.currency", "site.logo")</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_label" class="form-label">Label <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_label" name="label" required>
                            <div class="form-text">Display name for the setting (e.g., "Application Currency", "Site Logo")</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_group" class="form-label">Group <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_group" name="group" required list="edit-group-list">
                            <datalist id="edit-group-list">
                                @foreach($groups as $group)
                                    <option value="{{ $group }}">
                                @endforeach
                                <option value="general">
                                <option value="appearance">
                                <option value="email">
                                <option value="payment">
                                <option value="social">
                                <option value="api">
                            </datalist>
                            <div class="form-text">Category to group related settings</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_type" class="form-label">Data Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_data_type" name="data_type" required>
                                <option value="string">String</option>
                                <option value="integer">Integer</option>
                                <option value="boolean">Boolean (Yes/No)</option>
                                <option value="float">Float/Decimal</option>
                                <option value="array">Array (JSON)</option>
                                <option value="object">Object (JSON)</option>
                                <option value="file">File</option>
                                <option value="image">Image</option>
                                <option value="email">Email</option>
                                <option value="url">URL</option>
                                <option value="text">Text (Multiline)</option>
                                <option value="select">Select (Dropdown)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3 edit-select-options-container">
                        <label for="edit_options" class="form-label">Options <span class="text-danger options-required-indicator d-none">*</span></label>
                        <textarea class="form-control" id="edit_options" name="options" rows="3" placeholder='{"key1": "Value 1", "key2": "Value 2"}'></textarea>
                        <div class="form-text">JSON object for select options. Format: {"value": "label", "value2": "label2"}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                        <div class="form-text">Helpful text to explain the purpose of this setting</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_default_value" class="form-label">Default Value</label>
                        <input type="text" class="form-control" id="edit_default_value" name="default_value">
                        <div class="form-text">Initial value for this setting</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="edit_display_order" name="display_order" value="0" min="0">
                            <div class="form-text">Settings are sorted by this value (ascending)</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="edit_is_required" name="is_required" value="1">
                                <label class="form-check-label" for="edit_is_required">Required</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Direct modal handling for create button
        const createButton = document.querySelector('[data-bs-target="#createSchemaModal"]');
        const createModal = document.getElementById('createSchemaModal');
        
        if (createButton && createModal) {
            createButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Manually initialize and show modal
                const bsModal = new bootstrap.Modal(createModal);
                bsModal.show();
            });
        }
        
        // Show/hide select options based on data type selection
        const dataTypeSelect = document.getElementById('data_type');
        const optionsContainer = document.querySelector('.select-options-container');
        
        if (dataTypeSelect && optionsContainer) {
            dataTypeSelect.addEventListener('change', function() {
                if (this.value === 'select') {
                    optionsContainer.classList.remove('d-none');
                    document.getElementById('options').setAttribute('required', 'required');
                } else {
                    optionsContainer.classList.add('d-none');
                    document.getElementById('options').removeAttribute('required');
                }
            });
        }
        
        // Edit schema functionality
        const editButtons = document.querySelectorAll('.edit-schema');
        const editModal = document.getElementById('editSchemaModal');
        
        if (editButtons.length && editModal) {
            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    try {
                        const schemaData = JSON.parse(this.getAttribute('data-schema'));
                        const form = document.getElementById('editSchemaForm');
                        
                        // Set form action URL
                        form.action = `{{ route('admin.settings.schemas.update', '') }}/${schemaData.id}`;
                        
                        // Fill form fields
                        document.getElementById('edit_key').value = schemaData.key;
                        document.getElementById('edit_label').value = schemaData.label;
                        document.getElementById('edit_group').value = schemaData.group;
                        document.getElementById('edit_data_type').value = schemaData.data_type;
                        document.getElementById('edit_options').value = schemaData.options;
                        document.getElementById('edit_description').value = schemaData.description;
                        document.getElementById('edit_default_value').value = schemaData.default_value;
                        document.getElementById('edit_display_order').value = schemaData.display_order;
                        document.getElementById('edit_is_required').checked = schemaData.is_required;
                        document.getElementById('edit_is_active').checked = schemaData.is_active;
                        
                        // Show/hide options field based on data type
                        const editOptionsContainer = document.querySelector('.edit-select-options-container');
                        const optionsRequiredIndicator = document.querySelector('.options-required-indicator');
                        
                        if (schemaData.data_type === 'select') {
                            editOptionsContainer.style.display = 'block';
                            optionsRequiredIndicator.classList.remove('d-none');
                            document.getElementById('edit_options').setAttribute('required', 'required');
                        } else {
                            editOptionsContainer.style.display = 'none';
                            optionsRequiredIndicator.classList.add('d-none');
                            document.getElementById('edit_options').removeAttribute('required');
                        }
                        
                        // Handle data type change in edit form
                        const editDataTypeSelect = document.getElementById('edit_data_type');
                        editDataTypeSelect.addEventListener('change', function() {
                            if (this.value === 'select') {
                                editOptionsContainer.style.display = 'block';
                                optionsRequiredIndicator.classList.remove('d-none');
                                document.getElementById('edit_options').setAttribute('required', 'required');
                            } else {
                                editOptionsContainer.style.display = 'none';
                                optionsRequiredIndicator.classList.add('d-none');
                                document.getElementById('edit_options').removeAttribute('required');
                            }
                        });
                        
                        // Manually initialize and show modal
                        const bsModal = new bootstrap.Modal(editModal);
                        bsModal.show();
                    } catch (error) {
                        console.error('Error processing schema data:', error);
                    }
                });
            });
        }
        
        // Ensure modals are properly reset when hidden
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                // Remove backdrop if any left
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());
                
                // Reset body styles
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        });
    });
</script>
@endsection