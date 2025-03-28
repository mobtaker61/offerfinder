@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Payment Gateway: {{ $paymentGateway->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.finance.payment-gateways.index') }}" class="btn btn-default btn-sm">
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
                
                    <form action="{{ route('admin.finance.payment-gateways.update', $paymentGateway) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $paymentGateway->name) }}" required>
                            <small class="form-text text-muted">Internal name for the payment gateway</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="display_name">Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name', $paymentGateway->display_name) }}" required>
                            <small class="form-text text-muted">Name shown to administrators</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="code">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $paymentGateway->code) }}" required>
                            <small class="form-text text-muted">Unique identifier for this payment gateway (e.g., stripe, paypal)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $paymentGateway->description) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="configuration">Configuration (JSON)</label>
                            <textarea name="configuration" id="configuration" class="form-control" rows="10">{{ old('configuration', $paymentGateway->configuration ? json_encode($paymentGateway->configuration, JSON_PRETTY_PRINT) : '{}') }}</textarea>
                            <small class="form-text text-muted">Configuration settings in JSON format (API keys, credentials, etc.)</small>
                            
                            @if($paymentGateway->code === 'ziina')
                            <div class="mt-3 p-3 bg-light border rounded">
                                <h5>Ziina Configuration Example:</h5>
                                <p>To integrate with Ziina payment gateway, provide the following configuration in JSON format:</p>
                                <pre class="bg-white p-2">
{
    "access_token": "YOUR_ZIINA_ACCESS_TOKEN",
    "webhook_url": "{{ url('webhooks/ziina') }}"
}
</pre>
                                <p class="mt-2 mb-0"><small>You can get your Ziina access token by following <a href="https://docs.ziina.com/custom-integration" target="_blank">Ziina's documentation</a>.</small></p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $paymentGateway->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                            <small class="form-text text-muted d-block">If checked, this payment gateway will be available for use</small>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="hidden" name="is_test_mode" value="0">
                            <input type="checkbox" name="is_test_mode" class="form-check-input" id="is_test_mode" value="1" {{ old('is_test_mode', $paymentGateway->is_test_mode) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_test_mode">Test Mode</label>
                            <small class="form-text text-muted d-block">If checked, this gateway will operate in test/sandbox mode</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Payment Gateway</button>
                            <a href="{{ route('admin.finance.payment-gateways.index') }}" class="btn btn-default">Cancel</a>
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