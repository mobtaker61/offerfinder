@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Offer Category</h1>
    <a href="{{ route('admin.offer-categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.offer-categories.update', $offerCategory) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">None (Main Category)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('parent_id', $offerCategory->parent_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

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
                <label for="description">Description</label>
                <textarea
                    class="form-control @error('description') is-invalid @enderror"
                    id="description"
                    name="description"
                    rows="3">{{ old('description', $offerCategory->description) }}</textarea>
                @error('description')
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
    </div>
</div>

@if($offerCategory->hasChildren())
<div class="alert alert-info mt-4">
    <i class="fas fa-info-circle"></i> This category has {{ $offerCategory->children->count() }} subcategories.
    Changes to this category will affect all subcategories.
</div>
@endif

@endsection