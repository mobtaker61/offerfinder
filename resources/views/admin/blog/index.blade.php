@extends('layouts.admin')

@section('title', 'Blog Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Blog Posts</h1>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Post
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Scope</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->author->name }}</td>
                    <td>
                        @if($post->scope === 'global')
                        <span class="badge bg-info">Global</span>
                        @elseif($post->scope === 'market')
                        <span class="badge bg-primary">{{ $post->market->name ?? 'Market' }}</span>
                        @else
                        <span class="badge bg-secondary">{{ $post->branch->name ?? 'Branch' }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $post->is_active ? 'success' : 'danger' }}">
                            {{ $post->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-info" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No posts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection