<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\PaymentMethod;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Display the finance dashboard.
     */
    public function index()
    {
        // Get basic statistics
        $totalWallets = Wallet::count();
        $totalWalletsBalance = Wallet::sum('balance');
        $totalTransactions = WalletTransaction::count();
        $totalDeposits = WalletTransaction::where('amount', '>', 0)->sum('amount');
        $totalWithdrawals = abs(WalletTransaction::where('amount', '<', 0)->sum('amount'));
        
        // Get recent transactions
        $recentTransactions = WalletTransaction::with(['user', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get transaction stats by month for the last 6 months
        $monthlyStats = WalletTransaction::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as deposits'),
                DB::raw('SUM(CASE WHEN amount < 0 THEN ABS(amount) ELSE 0 END) as withdrawals')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Format for chart
        $months = [];
        $depositData = [];
        $withdrawalData = [];
        
        foreach ($monthlyStats as $stat) {
            $monthName = date('M Y', mktime(0, 0, 0, $stat->month, 1, $stat->year));
            $months[] = $monthName;
            $depositData[] = $stat->deposits;
            $withdrawalData[] = $stat->withdrawals;
        }
        
        // Get active payment methods
        $activePaymentMethods = PaymentMethod::where('is_active', true)->count();
        
        return view('admin.finance.dashboard', compact(
            'totalWallets',
            'totalWalletsBalance',
            'totalTransactions',
            'totalDeposits',
            'totalWithdrawals',
            'recentTransactions',
            'months',
            'depositData',
            'withdrawalData',
            'activePaymentMethods'
        ));
    }
    
    /**
     * Display user wallet balances overview.
     */
    public function userBalances(Request $request)
    {
        $query = User::with('wallet')
            ->whereHas('wallet');
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Sort options
        $sortField = $request->input('sort', 'wallet.balance');
        $sortDirection = $request->input('direction', 'desc');
        
        if ($sortField === 'wallet.balance') {
            $query->join('wallets', 'users.id', '=', 'wallets.user_id')
                  ->orderBy('wallets.balance', $sortDirection)
                  ->select('users.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }
        
        $users = $query->paginate(20)
            ->appends($request->query());
        
        return view('admin.finance.user_balances', compact('users'));
    }
}
