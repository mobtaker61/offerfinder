@extends('layouts.admin')

@section('title', 'Branches')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Branches</h1>
        <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Branch
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Market</th>
                        <th>Address</th>
                        <th>Coordinates</th>
                        <th>Contacts</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                    <tr>
                        <td>{{ $branch->id }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->market->name }}</td>
                        <td>{{ $branch->address }}</td>
                        <td>
                            @if($branch->latitude && $branch->longitude)
                                {{ number_format($branch->latitude, 6) }}, {{ number_format($branch->longitude, 6) }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>
                            @foreach($branch->contactProfiles as $profile)
                                <div>
                                    <small class="text-muted">{{ ucfirst($profile->type) }}:</small>
                                    {{ $profile->value }}
                                    @if($profile->is_primary)
                                        <span class="badge bg-primary">Primary</span>
                                    @endif
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge bg-{{ $branch->is_active ? 'success' : 'danger' }}">
                                {{ $branch->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $branch->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this branch?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No branches found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $branches->links() }}
        </div>
    </div>
</div>
@endsection
