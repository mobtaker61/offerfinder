@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalWallets) }}</h3>
                    <p>Total Wallets</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <a href="{{ route('admin.finance.user-balances') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalWalletsBalance, 2) }}</h3>
                    <p>Total Balance (AED)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('admin.finance.user-balances') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($totalTransactions) }}</h3>
                    <p>Total Transactions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <a href="{{ route('admin.finance.transactions.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $activePaymentMethods }}</h3>
                    <p>Payment Methods</p>
                </div>
                <div class="icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Transaction Summary -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Transaction Summary
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="text-center">
                            <h5>Total Deposits</h5>
                            <h3 class="text-success">{{ number_format($totalDeposits, 2) }} AED</h3>
                        </div>
                        <div class="text-center">
                            <h5>Total Withdrawals</h5>
                            <h3 class="text-danger">{{ number_format($totalWithdrawals, 2) }} AED</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calculator mr-1"></i>
                        Transaction Ratios
                    </h3>
                </div>
                <div class="card-body">
                    @php
                        $totalVolume = $totalDeposits + $totalWithdrawals;
                        $depositPercentage = $totalVolume > 0 ? ($totalDeposits / $totalVolume) * 100 : 0;
                        $withdrawalPercentage = $totalVolume > 0 ? ($totalWithdrawals / $totalVolume) * 100 : 0;
                    @endphp
                    
                    <div class="progress-group">
                        <span class="progress-text">Deposits</span>
                        <span class="float-right"><b>{{ number_format($totalDeposits, 2) }}</b> AED ({{ number_format($depositPercentage, 1) }}%)</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: <?php echo $depositPercentage; ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="progress-group mt-3">
                        <span class="progress-text">Withdrawals</span>
                        <span class="float-right"><b>{{ number_format($totalWithdrawals, 2) }}</b> AED ({{ number_format($withdrawalPercentage, 1) }}%)</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: <?php echo $withdrawalPercentage; ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Monthly Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Monthly Transaction Volume (Last 6 Months)
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Transactions</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-tool">
                            <i class="fas fa-list"></i> View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
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
                                        <td class="{{ $transaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($transaction->status == 'completed') badge-success 
                                                @elseif($transaction->status == 'pending') badge-warning 
                                                @elseif($transaction->status == 'failed') badge-danger 
                                                @else badge-secondary @endif">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.finance.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No transactions found</td>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart data
        const months = JSON.parse('<?php echo json_encode($months); ?>');
        const depositData = JSON.parse('<?php echo json_encode($depositData); ?>');
        const withdrawalData = JSON.parse('<?php echo json_encode($withdrawalData); ?>');
        
        const ctx = document.getElementById('transactionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Deposits',
                        data: depositData,
                        backgroundColor: 'rgba(40, 167, 69, 0.5)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Withdrawals',
                        data: withdrawalData,
                        backgroundColor: 'rgba(220, 53, 69, 0.5)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (AED)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Transaction Volume by Month'
                    }
                }
            }
        });

        // Ensure modals are not aria-hidden when shown
        $('#deleteModal1').on('show.bs.modal', function (e) {
            $(this).attr('aria-hidden', 'false');
        });
        $('#deleteModal1').on('hide.bs.modal', function (e) {
            $(this).attr('aria-hidden', 'true');
        });
    });
</script>
@endsection 