@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">My Transactions</h2>
                <a href="{{ route('profile.edit') }}#wallet" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Wallet
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Wallet Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Current Balance</span>
                        <span class="font-weight-bold">{{ number_format($wallet->balance, 2) }} AED</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Deposits</span>
                        <span class="text-success">{{ number_format($wallet->total_deposits, 2) }} AED</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Withdrawals</span>
                        <span class="text-danger">{{ number_format($wallet->total_withdrawals, 2) }} AED</span>
                    </div>
                    <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                        <i class="fas fa-plus-circle me-1"></i> Add Funds
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Transaction History</h5>

                    @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td class="{{ $transaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }} AED
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                        <p class="mb-0">No transactions found</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1" aria-labelledby="addFundsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFundsModalLabel">Add Funds to Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFundsForm" action="{{ route('wallet.add-funds') }}" method="POST">
                    @csrf
                    <input type="hidden" name="debug" value="1">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (AED)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="10" step="1" placeholder="Enter amount" required>
                        <div class="form-text">Minimum amount: 10 AED</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <div class="d-flex flex-column gap-2">
                            @php
                                $ziinaGateway = \App\Models\PaymentGateway::where('code', 'ziina')
                                    ->where('is_active', true)
                                    ->first();
                            @endphp
                            
                            @if($ziinaGateway)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="ziina" value="ziina" checked>
                                    <label class="form-check-label d-flex align-items-center" for="ziina">
                                        <img src="https://ziina.com/images/logo.png" alt="Ziina" height="24" class="me-2">
                                        Ziina {{ $ziinaGateway->is_test_mode ? '(Test Mode)' : '' }}
                                    </label>
                                </div>
                                <div class="alert alert-info mt-2 small">
                                    <i class="fas fa-info-circle me-1"></i> You will be redirected to Ziina's secure payment page.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    No payment methods are currently available. Please contact support.
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addFundsForm" class="btn btn-primary">Proceed to Payment</button>
            </div>
        </div>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger mt-3">
    {{ session('error') }}
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning mt-3">
    {{ session('warning') }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the form and submit button
        const addFundsForm = document.getElementById('addFundsForm');
        const submitButton = document.querySelector('button[form="addFundsForm"]');
        
        // Prevent modal from closing on submit
        addFundsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable the submit button to prevent double submission
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            // Log submission for debug
            console.log('Form submitted, redirecting...');
            
            // Submit the form
            this.submit();
        });
        
        // Log any errors
        @if (session('error'))
            console.error('Error occurred:', @json(session('error')));
        @endif
    });
</script>
@endpush