@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Offer Category</h1>
    <a href="{{ route('admin.offer-categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<form action="{{ route('admin.offer-categories.update', $offerCategory) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            name="name"
            value="{{ old('name', $offerCategory->name) }}"
            required>
        @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="icon">Icon (Font Awesome class)</label>
        <input type="text"
            class="form-control @error('icon') is-invalid @enderror"
            id="icon"
            name="icon"
            value="{{ old('icon', $offerCategory->icon) }}"
            placeholder="e.g., fas fa-tag">
        @error('icon')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="color">Color</label>
        <input type="color"
            class="form-control @error('color') is-invalid @enderror"
            id="color"
            name="color"
            value="{{ old('color', $offerCategory->color) }}">
        @error('color')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="order">Order</label>
        <input type="number"
            class="form-control @error('order') is-invalid @enderror"
            id="order"
            name="order"
            value="{{ old('order', $offerCategory->order) }}">
        @error('order')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox"
                class="custom-control-input"
                id="active"
                name="active"
                value="1"
                {{ old('active', $offerCategory->active) ? 'checked' : '' }}>
            <label class="custom-control-label" for="active">Active</label>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('admin.offer-categories.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@endsection