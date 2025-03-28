@extends('layouts.admin')

@section('title', 'Create Package')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Package</h1>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.packages.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    <div class="form-text">Display name for this package</div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    <div class="form-text">Detailed description of what this package includes</div>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Select Features</label>
                    <div class="card">
                        <div class="card-body">
                            @if($featureTypes->count() > 0)
                                @foreach($featureTypes as $featureType)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" 
                                           id="feature_{{ $featureType->id }}" 
                                           name="feature_types[]" 
                                           value="{{ $featureType->id }}"
                                           {{ in_array($featureType->id, old('feature_types', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_{{ $featureType->id }}">
                                        {{ $featureType->name }} 
                                        <small class="text-muted">({{ $featureType->key }})</small>
                                    </label>
                                </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning mb-0">
                                    No feature types available. <a href="{{ route('admin.feature-types.create') }}">Create some first</a>.
                                </div>
                            @endif
                        </div>
                    </div>
                    @error('feature_types')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary" {{ $featureTypes->count() == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Create Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 