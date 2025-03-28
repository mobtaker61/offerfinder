<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WalletTransactionController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        $query = WalletTransaction::with(['user', 'paymentMethod']);

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->input('transaction_type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->input('amount_min'));
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->input('amount_max'));
        }

        // Apply search term to related user or reference
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Sort options
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        $query->orderBy($sortField, $sortDirection);
        
        $transactions = $query->paginate(20)
            ->appends($request->query());
        
        // Get transaction types for filter
        $transactionTypes = WalletTransaction::select('transaction_type')
            ->distinct()
            ->pluck('transaction_type');
            
        // Get statuses for filter
        $statuses = WalletTransaction::select('status')
            ->distinct()
            ->pluck('status');
            
        // Get users for filter
        $users = User::whereHas('walletTransactions')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        return view('admin.finance.transactions', compact(
            'transactions', 
            'transactionTypes', 
            'statuses', 
            'users'
        ));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('display_order')->get();
        
        // If a user_id is provided in the query parameters, fetch that user's current balance
        $selectedUserId = $request->query('user_id');
        $selectedUserBalance = null;
        
        if ($selectedUserId) {
            $selectedUser = User::find($selectedUserId);
            if ($selectedUser) {
                $selectedUserBalance = $selectedUser->wallet ? $selectedUser->wallet->balance : 0;
            }
        }
        
        return view('admin.finance.transactions.create', compact('users', 'paymentMethods', 'selectedUserId', 'selectedUserBalance'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_type' => 'required|string',
            'operation' => 'required|in:add,deduct',
            'status' => 'required|string',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            if ($validated['operation'] === 'add') {
                $transaction = $this->walletService->addFunds(
                    $validated['user_id'],
                    $validated['amount'],
                    $validated['transaction_type'],
                    $validated['status'],
                    $validated['reference'] ?? null,
                    $validated['payment_method_id'] ?? null,
                    $validated['description'] ?? null
                );
            } else {
                // Check balance first
                if (!$this->walletService->hasSufficientFunds($validated['user_id'], $validated['amount'])) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['amount' => 'Insufficient funds in user wallet']);
                }
                
                $transaction = $this->walletService->deductFunds(
                    $validated['user_id'],
                    $validated['amount'],
                    $validated['transaction_type'],
                    $validated['status'],
                    $validated['reference'] ?? null,
                    $validated['payment_method_id'] ?? null,
                    $validated['description'] ?? null
                );
            }
            
            if (!$transaction) {
                throw new \Exception('Failed to create transaction');
            }
            
            return redirect()->route('admin.finance.transactions.index')
                ->with('success', 'Transaction created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified transaction.
     */
    public function show(WalletTransaction $transaction)
    {
        $transaction->load(['user', 'wallet', 'paymentMethod']);
        
        return view('admin.finance.transactions.show', compact('transaction'));
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request)
    {
        $query = WalletTransaction::with(['user', 'paymentMethod']);

        // Apply the same filters as index
        // (same filter code as index method)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->input('transaction_type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Sort options
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        $query->orderBy($sortField, $sortDirection);
        
        $transactions = $query->get();
        
        // Generate CSV file
        $filename = 'wallet_transactions_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID',
                'User',
                'Email',
                'Transaction Type',
                'Amount',
                'Balance Before',
                'Balance After',
                'Currency',
                'Status',
                'Reference',
                'Payment Method',
                'Description',
                'Date',
            ]);
            
            // Add data
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->user->name ?? 'N/A',
                    $transaction->user->email ?? 'N/A',
                    $transaction->transaction_type,
                    $transaction->amount,
                    $transaction->balance_before,
                    $transaction->balance_after,
                    $transaction->currency,
                    $transaction->status,
                    $transaction->reference ?? 'N/A',
                    $transaction->paymentMethod->name ?? 'N/A',
                    $transaction->description ?? 'N/A',
                    $transaction->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
