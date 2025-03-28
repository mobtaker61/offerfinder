@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Payment Method: {{ $paymentMethod->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.finance.payment-methods.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                
                    <form action="{{ route('admin.finance.payment-methods.update', $paymentMethod) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $paymentMethod->name) }}" required>
                            <small class="form-text text-muted">Internal name for the payment method</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="display_name">Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name', $paymentMethod->display_name) }}" required>
                            <small class="form-text text-muted">Name shown to users</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="code">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $paymentMethod->code) }}" required>
                            <small class="form-text text-muted">Unique identifier for this payment method (e.g., credit_card, bank_transfer)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $paymentMethod->description) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_gateway_id">Payment Gateway</label>
                            <select name="payment_gateway_id" id="payment_gateway_id" class="form-control">
                                <option value="">-- Select Payment Gateway --</option>
                                @foreach($paymentGateways as $gateway)
                                    <option value="{{ $gateway->id }}" {{ old('payment_gateway_id', $paymentMethod->payment_gateway_id) == $gateway->id ? 'selected' : '' }}>
                                        {{ $gateway->name }} ({{ $gateway->code }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">The payment gateway that processes this payment method</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="instructions">Instructions</label>
                            <textarea name="instructions" id="instructions" class="form-control" rows="3">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                            <small class="form-text text-muted">Instructions for users on how to use this payment method</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="configuration">Configuration (JSON)</label>
                            <textarea name="configuration" id="configuration" class="form-control" rows="5">{{ old('configuration', json_encode($paymentMethod->configuration, JSON_PRETTY_PRINT)) }}</textarea>
                            <small class="form-text text-muted">Configuration settings in JSON format</small>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                            <small class="form-text text-muted d-block">If checked, this payment method will be available for use</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Payment Method</button>
                            <a href="{{ route('admin.finance.payment-methods.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const codeInput = document.getElementById('code');
        const displayNameInput = document.getElementById('display_name');
        
        // Auto-generate code from name if code is empty
        nameInput.addEventListener('blur', function() {
            if (codeInput.value === '') {
                codeInput.value = nameInput.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '_')
                    .replace(/^_+|_+$/g, '');
            }
        });
    });
</script>
@endpush 