@extends('layouts.admin')

@section('title', 'Manage Pages')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pages</h1>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Page
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="pagesTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Last Updated</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->slug }}</td>
                    <td>
                        <span class="badge bg-{{ $page->is_active ? 'success' : 'danger' }}">
                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $page->sort_order }}</td>
                    <td>{{ $page->updated_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('pages.show', $page->slug) }}"
                                class="btn btn-sm btn-info"
                                target="_blank"
                                title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.pages.edit', $page) }}"
                                class="btn btn-sm btn-primary"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pages.destroy', $page) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this page?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#pagesTable').DataTable({
            order: [
                [3, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: 5
            }]
        });
    });
</script>
@endpush