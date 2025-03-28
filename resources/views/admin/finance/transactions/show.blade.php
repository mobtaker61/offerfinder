@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="transaction-header mb-4">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <h4>
                                    <span class="badge badge-pill {{ $transaction->amount > 0 ? 'badge-success' : 'badge-danger' }} p-2">
                                        {{ ucfirst($transaction->transaction_type) }}
                                    </span>
                                    <span class="ml-2 {{ $transaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }} {{ $transaction->currency ?? 'USD' }}
                                    </span>
                                    <span class="badge badge-pill 
                                        @if($transaction->status == 'completed') badge-success 
                                        @elseif($transaction->status == 'pending') badge-warning 
                                        @elseif($transaction->status == 'failed') badge-danger 
                                        @else badge-secondary @endif float-right p-2">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">Transaction Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">Transaction ID:</th>
                                            <td><strong>{{ $transaction->id }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Reference:</th>
                                            <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date:</th>
                                            <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method:</th>
                                            <td>{{ $transaction->paymentMethod ? $transaction->paymentMethod->name : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description:</th>
                                            <td>{{ $transaction->description ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">User Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">User:</th>
                                            <td>
                                                @if($transaction->user)
                                                    <a href="{{ route('admin.users.show', $transaction->user->id) }}">
                                                        {{ $transaction->user->name }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ $transaction->user->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Balance Before:</th>
                                            <td>{{ number_format($transaction->balance_before, 2) }} {{ $transaction->currency ?? 'USD' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Balance After:</th>
                                            <td>{{ number_format($transaction->balance_after, 2) }} {{ $transaction->currency ?? 'USD' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Current Balance:</th>
                                            <td>
                                                @if($transaction->user && $transaction->user->wallet)
                                                    {{ number_format($transaction->user->wallet->balance, 2) }} {{ $transaction->currency ?? 'USD' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($transaction->user)
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Recent User Transactions</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Reference</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transaction->user->walletTransactions()->where('id', '!=', $transaction->id)->latest()->limit(5)->get() as $userTransaction)
                                            <tr>
                                                <td>{{ $userTransaction->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <span class="badge {{ $userTransaction->amount > 0 ? 'badge-success' : 'badge-danger' }}">
                                                        {{ ucfirst($userTransaction->transaction_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="{{ $userTransaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ $userTransaction->amount > 0 ? '+' : '' }}{{ number_format($userTransaction->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @if($userTransaction->status == 'completed') badge-success 
                                                        @elseif($userTransaction->status == 'pending') badge-warning 
                                                        @elseif($userTransaction->status == 'failed') badge-danger 
                                                        @else badge-secondary @endif">
                                                        {{ ucfirst($userTransaction->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.finance.transactions.show', $userTransaction->id) }}">
                                                        {{ $userTransaction->reference ?? 'Transaction #' . $userTransaction->id }}
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No other transactions found for this user</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.finance.transactions.index', ['user_id' => $transaction->user_id]) }}" class="btn btn-sm btn-primary">
                                    View All User Transactions
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 