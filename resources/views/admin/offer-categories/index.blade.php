@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Offer Categories</h1>
        <a href="{{ route('admin.offer-categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>

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

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Icon</th>
                <th>Color</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mainCategories as $category)
            <tr class="main-category">
                <td>
                    <strong>{{ $category->name }}</strong>
                    @if($category->hasChildren())
                    <span class="badge badge-info ml-2">{{ $category->children->count() }} subcategories</span>
                    @endif
                </td>
                <td>{{ Str::limit($category->description, 50) }}</td>
                <td>
                    @if($category->icon)
                    <i class="{{ $category->icon }}"></i>
                    @endif
                </td>
                <td>
                    @if($category->color)
                    <span class="badge color-badge" data-color="{{ $category->color }}">
                        {{ $category->color }}
                    </span>
                    @endif
                </td>
                <td>{{ $category->order }}</td>
                <td>
                    <span class="badge badge-{{ $category->active ? 'success' : 'danger' }}">
                        {{ $category->active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.offer-categories.edit', $category) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.offer-categories.destroy', $category) }}"
                        method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this category? This will also affect all subcategories.')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @foreach($category->children as $child)
            <tr class="subcategory">
                <td>
                    <div class="pl-4">
                        <i class="fas fa-level-down-alt text-muted mr-2"></i>
                        {{ $child->name }}
                    </div>
                </td>
                <td>{{ Str::limit($child->description, 50) }}</td>
                <td>
                    @if($child->icon)
                    <i class="{{ $child->icon }}"></i>
                    @endif
                </td>
                <td>
                    @if($child->color)
                    <span class="badge color-badge" data-color="{{ $child->color }}">
                        {{ $child->color }}
                    </span>
                    @endif
                </td>
                <td>{{ $child->order }}</td>
                <td>
                    <span class="badge badge-{{ $child->active ? 'success' : 'danger' }}">
                        {{ $child->active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.offer-categories.edit', $child) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.offer-categories.destroy', $child) }}"
                        method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this subcategory?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>

</div>
@endsection

@section('styles')
<style>
    .subcategory {
        background-color: #f8f9fc;
    }

    .color-badge {
        width: 50px;
        height: 25px;
        display: inline-block;
        color: white;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.color-badge').forEach(badge => {
            badge.style.backgroundColor = badge.dataset.color;
        });
    });
</script>
@endsection