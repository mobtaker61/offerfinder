@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>User Management</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="img-thumbnail" style="max-width: 50px;">
                            @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-{{ $user->user_type === 'webmaster' ? 'danger' : ($user->user_type === 'admin' ? 'warning' : 'info') }}">
                                {{ ucfirst($user->user_type) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
    .avatar-placeholder {
        width: 50px;
        height: 50px;
        background-color: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
</style>
@endsection