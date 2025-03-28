@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Wallet Transaction</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-default btn-sm">
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
                
                    <form action="{{ route('admin.finance.transactions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">User <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control select2" required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $selectedUserId) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        @if(isset($selectedUserBalance))
                        <div class="form-group">
                            <div class="alert alert-info">
                                <strong>Current Balance:</strong> {{ number_format($selectedUserBalance, 2) }} AED
                            </div>
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label>Operation <span class="text-danger">*</span></label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="operation_add" name="operation" value="add" class="custom-control-input" {{ old('operation', 'add') == 'add' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="operation_add">Add Funds</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="operation_deduct" name="operation" value="deduct" class="custom-control-input" {{ old('operation') == 'deduct' ? 'checked' : '' }} required>
                                <label class="custom-control-label" for="operation_deduct">Deduct Funds</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="amount">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" value="{{ old('amount') }}" required>
                            </div>
                            <small class="form-text text-muted">Enter a positive number. The system will handle the sign based on the operation type.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="transaction_type">Transaction Type <span class="text-danger">*</span></label>
                            <select name="transaction_type" id="transaction_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="deposit" {{ old('transaction_type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                                <option value="withdrawal" {{ old('transaction_type') == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                                <option value="refund" {{ old('transaction_type') == 'refund' ? 'selected' : '' }}>Refund</option>
                                <option value="adjustment" {{ old('transaction_type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                                <option value="payment" {{ old('transaction_type') == 'payment' ? 'selected' : '' }}>Payment</option>
                                <option value="bonus" {{ old('transaction_type') == 'bonus' ? 'selected' : '' }}>Bonus</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="completed" {{ old('status', 'completed') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_method_id">Payment Method</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-control">
                                <option value="">None</option>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="reference">Reference</label>
                            <input type="text" name="reference" id="reference" class="form-control" value="{{ old('reference') }}" maxlength="255">
                            <small class="form-text text-muted">Optional reference number or identifier for this transaction</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Transaction</button>
                            <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px;
        line-height: 38px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a user",
            allowClear: true
        });
    });
</script>
@endpush 