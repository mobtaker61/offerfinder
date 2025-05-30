@extends('layouts.admin')

@section('title', 'Create Feature Type')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Feature Type</h1>
        <a href="{{ route('admin.feature-types.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.feature-types.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    <div class="form-text">Display name for this feature (e.g. "Monthly Offers")</div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="key" class="form-label">Key</label>
                    <input type="text" class="form-control @error('key') is-invalid @enderror" 
                           id="key" name="key" value="{{ old('key') }}" required>
                    <div class="form-text">Unique identifier for this feature (e.g. "monthly_offers")</div>
                    @error('key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    <div class="form-text">Detailed explanation of what this feature does</div>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="value_type" class="form-label">Value Type</label>
                    <select class="form-control @error('value_type') is-invalid @enderror" 
                            id="value_type" name="value_type" required>
                        <option value="integer" {{ old('value_type') == 'integer' ? 'selected' : '' }}>Integer (for quantity limits)</option>
                        <option value="boolean" {{ old('value_type') == 'boolean' ? 'selected' : '' }}>Boolean (yes/no feature)</option>
                        <option value="string" {{ old('value_type') == 'string' ? 'selected' : '' }}>String (text value)</option>
                    </select>
                    <div class="form-text">Type of value this feature will store</div>
                    @error('value_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Feature Type
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
        const nameInput = document.getElementById('name');
        const keyInput = document.getElementById('key');
        
        // Generate key from name
        nameInput.addEventListener('blur', function() {
            if (keyInput.value === '') {
                keyInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '_')
                    .replace(/^_+|_+$/g, '');
            }
        });
    });
</script>
@endsection 