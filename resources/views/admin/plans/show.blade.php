@extends('layouts.admin')

@section('title', 'Plan Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Plan Details</h1>
        <div>
            <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $plan->name }}</h6>
            <div>
                <span class="badge bg-{{ $plan->is_active ? 'success' : 'danger' }}">
                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $plan->id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $plan->name }}</td>
                        </tr>
                        <tr>
                            <th>Package:</th>
                            <td>
                                <a href="{{ route('admin.packages.show', $plan->package_id) }}">
                                    {{ $plan->package->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Monthly Price:</th>
                            <td>${{ number_format($plan->monthly_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Yearly Price:</th>
                            <td>${{ number_format($plan->yearly_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $plan->description ?: 'No description provided' }}</td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $plan->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $plan->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0">Feature Values</h6>
                        </div>
                        <div class="card-body">
                            @if($plan->featureValues->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Feature</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($plan->featureValues as $featureValue)
                                                <tr>
                                                    <td>
                                                        {{ $featureValue->featureType->name }}
                                                        <small class="text-muted d-block">
                                                            ({{ $featureValue->featureType->key }})
                                                        </small>
                                                    </td>
                                                    <td>
                                                        @if($featureValue->featureType->value_type == 'boolean')
                                                            <span class="badge bg-{{ $featureValue->typed_value ? 'success' : 'danger' }}">
                                                                {{ $featureValue->typed_value ? 'Yes' : 'No' }}
                                                            </span>
                                                        @else
                                                            {{ $featureValue->value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">No feature values set for this plan.</div>
                            @endif
                        </div>
                    </div>
                    
                    @if($plan->markets->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Markets Using This Plan</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($plan->markets as $market)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('admin.markets.edit', $market->id) }}">
                                                    {{ $market->name }}
                                                </a>
                                                @if(!$market->is_active)
                                                    <span class="badge bg-warning ms-2">Inactive</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Markets</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info mb-0">No markets are currently using this plan.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 