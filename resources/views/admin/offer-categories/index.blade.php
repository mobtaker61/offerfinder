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

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Icon</th>
                <th>Color</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
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
                            onclick="return confirm('Are you sure you want to delete this category?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.color-badge').forEach(badge => {
            badge.style.backgroundColor = badge.dataset.color;
        });
    });
</script>
@endpush