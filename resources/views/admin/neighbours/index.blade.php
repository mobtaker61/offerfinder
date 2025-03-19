@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Neighbours</h1>
        <a href="{{ route('admin.neighbours.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Neighbour
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Local Name</th>
                    <th>District</th>
                    <th>Emirate</th>
                    <th>Coordinates</th>
                    <th>Info Link</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($neighbours as $neighbour)
                <tr>
                    <td>{{ $neighbour->id }}</td>
                    <td>{{ $neighbour->name }}</td>
                    <td>{{ $neighbour->local_name }}</td>
                    <td>{{ $neighbour->district->name }}</td>
                    <td>{{ $neighbour->district->emirate->name }}</td>
                    <td>
                        @if($neighbour->latitude && $neighbour->longitude)
                        {{ number_format($neighbour->latitude, 6) }}, {{ number_format($neighbour->longitude, 6) }}
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </td>
                    <td>
                        @if($neighbour->info_link)
                        <a href="{{ $neighbour->info_link }}" target="_blank" class="btn btn-sm btn-link">
                            <i class="fas fa-external-link-alt"></i> View
                        </a>
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $neighbour->is_active ? 'success' : 'danger' }}">
                            {{ $neighbour->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $neighbour->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.neighbours.edit', $neighbour) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.neighbours.destroy', $neighbour) }}"
                                method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this neighbour?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No neighbours found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $neighbours->links() }}
    </div>
</div>
@endsection