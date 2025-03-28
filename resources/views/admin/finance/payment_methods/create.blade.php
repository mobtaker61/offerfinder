@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Payment Method</h3>
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
                
                    <form action="{{ route('admin.finance.payment-methods.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            <small class="form-text text-muted">Internal name for the payment method</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="display_name">Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name') }}" required>
                            <small class="form-text text-muted">Name shown to users</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="code">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                            <small class="form-text text-muted">Unique identifier for this payment method (e.g., credit_card, paypal)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_gateway_id">Payment Gateway</label>
                            <select name="payment_gateway_id" id="payment_gateway_id" class="form-control">
                                <option value="">None (Manual Payment)</option>
                                @foreach ($paymentGateways as $gateway)
                                    <option value="{{ $gateway->id }}" {{ old('payment_gateway_id') == $gateway->id ? 'selected' : '' }}>
                                        {{ $gateway->name }} {{ $gateway->is_test_mode ? '(Test Mode)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">The payment gateway processor</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="icon">Icon URL</label>
                            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">
                            <small class="form-text text-muted">URL to the payment method icon</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="display_order">Display Order</label>
                            <input type="number" name="display_order" id="display_order" class="form-control" value="{{ old('display_order', 0) }}" min="0">
                            <small class="form-text text-muted">Order in which this payment method is displayed (lower numbers first)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="settings">Settings (JSON)</label>
                            <textarea name="settings" id="settings" class="form-control" rows="5">{{ old('settings', '{}') }}</textarea>
                            <small class="form-text text-muted">Additional configuration settings in JSON format</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                            <small class="form-text text-muted">If checked, this payment method will be available for use</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Payment Method</button>
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
        
        // Auto-generate code from name
        nameInput.addEventListener('blur', function() {
            if (codeInput.value === '') {
                codeInput.value = nameInput.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '_')
                    .replace(/^_+|_+$/g, '');
            }
        });
        
        // Auto-populate display name if empty
        nameInput.addEventListener('blur', function() {
            if (displayNameInput.value === '') {
                displayNameInput.value = nameInput.value;
            }
        });
    });
</script>
@endpush 