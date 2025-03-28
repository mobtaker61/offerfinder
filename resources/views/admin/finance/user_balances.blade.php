@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">User Wallet Balances</h3>
                    <div>
                        <a href="{{ route('admin.finance.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-chart-bar"></i> Finance Dashboard
                        </a>
                        <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-exchange-alt"></i> Transactions
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.finance.user-balances') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search by Name or Email</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sort By</label>
                                    <select name="sort" class="form-control">
                                        <option value="wallet.balance" {{ request('sort', 'wallet.balance') == 'wallet.balance' ? 'selected' : '' }}>Balance</option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
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
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group w-100 mb-0">
                                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                    <a href="{{ route('admin.finance.user-balances') }}" class="btn btn-secondary">Reset</a>
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
                                    <th>Email</th>
                                    <th>Wallet Balance</th>
                                    <th>Currency</th>
                                    <th>Last Transaction</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user->id) }}">
                                                {{ $user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-right">
                                            <span class="font-weight-bold {{ $user->wallet->balance > 0 ? 'text-success' : ($user->wallet->balance < 0 ? 'text-danger' : '') }}">
                                                {{ number_format($user->wallet->balance, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->wallet->currency }}</td>
                                        <td>
                                            @php
                                                $lastTransaction = $user->walletTransactions()->latest()->first();
                                            @endphp
                                            @if($lastTransaction)
                                                <small>
                                                    {{ $lastTransaction->created_at->format('Y-m-d H:i') }} - 
                                                    <span class="{{ $lastTransaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ $lastTransaction->amount > 0 ? '+' : '' }}{{ number_format($lastTransaction->amount, 2) }}
                                                    </span>
                                                </small>
                                            @else
                                                <small class="text-muted">No transactions</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.finance.transactions.index', ['user_id' => $user->id]) }}" class="btn btn-info btn-sm" title="View Transactions">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <a href="{{ route('admin.finance.transactions.create', ['user_id' => $user->id]) }}" class="btn btn-success btn-sm" title="Add/Deduct Funds">
                                                <i class="fas fa-wallet"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No users with wallets found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 