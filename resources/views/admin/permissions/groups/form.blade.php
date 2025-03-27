@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($group) ? 'Edit Permission Group' : 'Create Permission Group' }}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ isset($group) ? route('admin.permission-groups.update', $group) : route('admin.permission-groups.store') }}" 
                          method="POST">
                        @csrf
                        @if(isset($group))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $group->name ?? '') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $group->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Permissions</label>
                            <div class="row">
                                @foreach($availablePermissions as $key => $label)
                                    <div class="col-md-4 mb-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   id="permission_{{ $key }}" 
                                                   name="permissions[]" 
                                                   value="{{ $key }}"
                                                   {{ in_array($key, old('permissions', $group->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="permission_{{ $key }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($group) ? 'Update Group' : 'Create Group' }}
                            </button>
                            <a href="{{ route('admin.permission-groups.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 