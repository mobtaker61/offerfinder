@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Wallet Transactions</h3>
                    <div>
                        <a href="{{ route('admin.finance.transactions.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Transaction
                        </a>
                        <a href="{{ route('admin.finance.transactions.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-export"></i> Export CSV
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.finance.transactions.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Reference or user" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>User</label>
                                    <select name="user_id" class="form-control select2">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select name="transaction_type" class="form-control">
                                        <option value="">All Types</option>
                                        @foreach($transactionTypes as $type)
                                            <option value="{{ $type }}" {{ request('transaction_type') == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date Range</label>
                                    <div class="input-group">
                                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                        <div class="input-group-append input-group-prepend">
                                            <span class="input-group-text">to</span>
                                        </div>
                                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Amount Range</label>
                                    <div class="input-group">
                                        <input type="number" name="amount_min" class="form-control" placeholder="Min" value="{{ request('amount_min') }}" step="0.01">
                                        <div class="input-group-append input-group-prepend">
                                            <span class="input-group-text">to</span>
                                        </div>
                                        <input type="number" name="amount_max" class="form-control" placeholder="Max" value="{{ request('amount_max') }}" step="0.01">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sort By</label>
                                    <select name="sort" class="form-control">
                                        <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Date</option>
                                        <option value="amount" {{ request('sort') == 'amount' ? 'selected' : '' }}>Amount</option>
                                        <option value="transaction_type" {{ request('sort') == 'transaction_type' ? 'selected' : '' }}>Type</option>
                                        <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Direction</label>
                                    <select name="direction" class="form-control">
                                        <option value="desc" {{ request('direction', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-group w-100 mb-0">
                                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                    <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Balance After</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>
                                            @if($transaction->user)
                                                <a href="{{ route('admin.users.show', $transaction->user->id) }}">
                                                    {{ $transaction->user->name }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $transaction->amount > 0 ? 'badge-success' : 'badge-danger' }}">
                                                {{ ucfirst($transaction->transaction_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="{{ $transaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($transaction->balance_after, 2) }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($transaction->status == 'completed') badge-success 
                                                @elseif($transaction->status == 'pending') badge-warning 
                                                @elseif($transaction->status == 'failed') badge-danger 
                                                @else badge-secondary @endif">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->paymentMethod ? $transaction->paymentMethod->name : 'N/A' }}</td>
                                        <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.finance.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No transactions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
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
        $('.select2').select2();
    });
</script>
@endpush 