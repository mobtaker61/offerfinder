@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Payment Methods</h3>
                    <div>
                        <a href="{{ route('admin.finance.payment-methods.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Payment Method
                        </a>
                        <a href="{{ route('admin.finance.payment-gateways.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-server"></i> Manage Gateways
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Code</th>
                                    <th>Gateway</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentMethods as $method)
                                    <tr>
                                        <td>{{ $method->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($method->icon)
                                                    <img src="{{ $method->icon }}" alt="{{ $method->name }}" class="mr-2" style="width: 24px; height: 24px;">
                                                @else
                                                    <i class="fas fa-credit-card mr-2"></i>
                                                @endif
                                                {{ $method->name }}
                                            </div>
                                        </td>
                                        <td>{{ $method->display_name }}</td>
                                        <td><code>{{ $method->code }}</code></td>
                                        <td>
                                            @if($method->paymentGateway)
                                                <a href="{{ route('admin.finance.payment-gateways.show', $method->payment_gateway_id) }}">
                                                    {{ $method->paymentGateway->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.finance.payment-methods.toggle-active', $method) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $method->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $method->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{ $method->display_order }}</td>
                                        <td>
                                            <a href="{{ route('admin.finance.payment-methods.show', $method) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.finance.payment-methods.edit', $method) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $method->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $method->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $method->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $method->id }}">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete the payment method <strong>{{ $method->name }}</strong>?
                                                            <p class="text-danger mt-2">This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.finance.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No payment methods found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 