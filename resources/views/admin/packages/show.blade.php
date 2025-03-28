@extends('layouts.admin')

@section('title', 'Package Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Package Details</h1>
        <div>
            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $package->name }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $package->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $package->name }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $package->description ?: 'No description provided' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $package->is_active ? 'success' : 'danger' }}">
                                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $package->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $package->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0">Included Features</h6>
                        </div>
                        <div class="card-body">
                            @if($package->featureTypes->count() > 0)
                                <ul class="list-group">
                                    @foreach($package->featureTypes as $featureType)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                {{ $featureType->name }}
                                                <small class="text-muted">({{ $featureType->key }})</small>
                                                @if(!$featureType->is_active)
                                                    <span class="badge bg-warning ms-2">Inactive</span>
                                                @endif
                                            </div>
                                            <span class="badge bg-primary">{{ ucfirst($featureType->value_type) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="alert alert-warning mb-0">No features included in this package.</div>
                            @endif
                        </div>
                    </div>
                    
                    @if($package->plans->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Associated Plans</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($package->plans as $plan)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('admin.plans.show', $plan->id) }}">
                                                    {{ $plan->name }}
                                                </a>
                                                @if(!$plan->is_active)
                                                    <span class="badge bg-warning ms-2">Inactive</span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="me-3">
                                                    Monthly: ${{ number_format($plan->monthly_price, 2) }}
                                                </span>
                                                <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
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