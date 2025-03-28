@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Payment Gateways</h3>
                    <div>
                        <a href="{{ route('admin.finance.payment-gateways.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Payment Gateway
                        </a>
                        <a href="{{ route('admin.finance.payment-methods.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-credit-card"></i> Manage Methods
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
                                    <th>Methods</th>
                                    <th>Status</th>
                                    <th>Mode</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentGateways as $gateway)
                                    <tr>
                                        <td>{{ $gateway->id }}</td>
                                        <td>{{ $gateway->name }}</td>
                                        <td>{{ $gateway->display_name }}</td>
                                        <td><code>{{ $gateway->code }}</code></td>
                                        <td>
                                            <span class="badge badge-info">{{ $gateway->payment_methods_count }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.finance.payment-gateways.toggle-active', $gateway) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $gateway->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $gateway->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.finance.payment-gateways.toggle-test-mode', $gateway) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $gateway->is_test_mode ? 'btn-warning' : 'btn-info' }}">
                                                    {{ $gateway->is_test_mode ? 'Test' : 'Live' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.finance.payment-gateways.show', $gateway) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.finance.payment-gateways.edit', $gateway) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $gateway->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $gateway->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $gateway->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $gateway->id }}">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete the payment gateway <strong>{{ $gateway->name }}</strong>?
                                                            <p class="text-danger mt-2">This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.finance.payment-gateways.destroy', $gateway) }}" method="POST" class="d-inline">
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
                                        <td colspan="8" class="text-center">No payment gateways found</td>
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