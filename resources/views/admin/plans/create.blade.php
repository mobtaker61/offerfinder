@extends('layouts.admin')

@section('title', 'Create Plan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Plan</h1>
        <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.plans.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Plan Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="package_id" class="form-label">Select Package</label>
                    <select class="form-select @error('package_id') is-invalid @enderror" 
                            id="package_id" name="package_id" required>
                        <option value="">-- Select a Package --</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }} ({{ $package->featureTypes->count() }} features)
                            </option>
                        @endforeach
                    </select>
                    @error('package_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="monthly_price" class="form-label">Monthly Price ($)</label>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('monthly_price') is-invalid @enderror" 
                                   id="monthly_price" name="monthly_price" 
                                   value="{{ old('monthly_price', 0) }}" required>
                            @error('monthly_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="yearly_price" class="form-label">Yearly Price ($)</label>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('yearly_price') is-invalid @enderror" 
                                   id="yearly_price" name="yearly_price" 
                                   value="{{ old('yearly_price', 0) }}" required>
                            @error('yearly_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                
                <div id="feature-values-container" class="mb-4">
                    <h5 class="mt-4 mb-3">Feature Values</h5>
                    <div class="alert alert-info">
                        Select a package to configure feature values
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const packageSelect = document.getElementById('package_id');
        const featureValuesContainer = document.getElementById('feature-values-container');
        
        // Load feature types when package is selected
        packageSelect.addEventListener('change', function() {
            const packageId = this.value;
            
            if (!packageId) {
                featureValuesContainer.innerHTML = `
                    <h5 class="mt-4 mb-3">Feature Values</h5>
                    <div class="alert alert-info">
                        Select a package to configure feature values
                    </div>
                `;
                return;
            }
            
            featureValuesContainer.innerHTML = `
                <h5 class="mt-4 mb-3">Feature Values</h5>
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading features...</p>
                </div>
            `;
            
            // Fetch features for the selected package
            fetch(`/admin/packages/${packageId}/features`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        featureValuesContainer.innerHTML = `
                            <h5 class="mt-4 mb-3">Feature Values</h5>
                            <div class="alert alert-warning">
                                This package has no features. Please add features to the package first.
                            </div>
                        `;
                        return;
                    }
                    
                    let html = `<h5 class="mt-4 mb-3">Feature Values</h5>`;
                    
                    data.forEach(feature => {
                        let inputType = 'text';
                        let placeholder = 'Enter value';
                        let defaultValue = '';
                        
                        if (feature.value_type === 'integer') {
                            inputType = 'number';
                            placeholder = 'Enter number';
                            defaultValue = '0';
                        } else if (feature.value_type === 'boolean') {
                            inputType = 'select';
                            placeholder = 'Select value';
                        }
                        
                        html += `
                            <div class="mb-3">
                                <label for="feature_value_${feature.id}" class="form-label">
                                    ${feature.name}
                                    <small class="text-muted">(${feature.key}) - ${feature.value_type}</small>
                                </label>
                        `;
                        
                        if (inputType === 'select') {
                            html += `
                                <select class="form-select" id="feature_value_${feature.id}" 
                                        name="feature_values[${feature.id}]" required>
                                    <option value="0">No (Disabled)</option>
                                    <option value="1">Yes (Enabled)</option>
                                </select>
                            `;
                        } else {
                            html += `
                                <input type="${inputType}" class="form-control" 
                                       id="feature_value_${feature.id}" 
                                       name="feature_values[${feature.id}]"
                                       placeholder="${placeholder}" 
                                       value="${defaultValue}" required>
                            `;
                        }
                        
                        if (feature.description) {
                            html += `
                                <div class="form-text">${feature.description}</div>
                            `;
                        }
                        
                        html += `</div>`;
                    });
                    
                    featureValuesContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    featureValuesContainer.innerHTML = `
                        <h5 class="mt-4 mb-3">Feature Values</h5>
                        <div class="alert alert-danger">
                            Failed to load features. Please try again.
                        </div>
                    `;
                });
        });
        
        // Trigger change event if package is already selected (e.g. when form validation fails)
        if (packageSelect.value) {
            packageSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection 