@extends('layouts.admin')

@section('title', 'Feature Type Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Feature Type Details</h1>
        <div>
            <a href="{{ route('admin.feature-types.edit', $featureType->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.feature-types.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $featureType->name }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $featureType->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $featureType->name }}</td>
                        </tr>
                        <tr>
                            <th>Key:</th>
                            <td><code>{{ $featureType->key }}</code></td>
                        </tr>
                        <tr>
                            <th>Value Type:</th>
                            <td>{{ ucfirst($featureType->value_type) }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $featureType->is_active ? 'success' : 'danger' }}">
                                    {{ $featureType->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $featureType->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $featureType->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0">Description</h6>
                        </div>
                        <div class="card-body">
                            @if($featureType->description)
                                {{ $featureType->description }}
                            @else
                                <em>No description provided</em>
                            @endif
                        </div>
                    </div>
                    
                    @if($featureType->packages->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Used in Packages</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($featureType->packages as $package)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('admin.packages.show', $package->id) }}">
                                                    {{ $package->name }}
                                                </a>
                                                @if(!$package->is_active)
                                                    <span class="badge bg-warning ms-2">Inactive</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 