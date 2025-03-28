<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display the user's wallet transactions
     */
    public function transactions()
    {
        $user = Auth::user();
        
        // Get or create wallet
        $wallet = $user->wallet ?? Wallet::firstOrCreate(['user_id' => $user->id]);
        
        // Get transactions with pagination
        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('wallet.transactions', compact('wallet', 'transactions'));
    }
    
    /**
     * Process adding funds to the wallet
     */
    public function addFunds(Request $request)
    {
        try {
            \Illuminate\Support\Facades\Log::info('Wallet addFunds method called', [
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
            ]);
            
            $request->validate([
                'amount' => 'required|numeric|min:10',
                'payment_method' => 'required|string',
            ]);
            
            $user = Auth::user();
            
            // Get or create wallet
            $wallet = $user->wallet ?? Wallet::firstOrCreate(['user_id' => $user->id]);
            
            \Illuminate\Support\Facades\Log::info('User wallet found/created', [
                'wallet_id' => $wallet->id,
                'balance' => $wallet->balance,
            ]);
            
            // Create pending transaction
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'description' => 'Wallet top-up',
                'transaction_type' => 'deposit',
                'status' => 'pending',
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance,
            ]);
            
            // Log transaction creation
            \Illuminate\Support\Facades\Log::info('Wallet top-up transaction created', [
                'transaction_id' => $transaction->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method
            ]);
            
            // Redirect to appropriate payment method
            switch ($request->payment_method) {
                case 'ziina':
                    $redirectUrl = route('payment.ziina.initialize', $transaction->id);
                    \Illuminate\Support\Facades\Log::info('Redirecting to Ziina payment', [
                        'transaction_id' => $transaction->id,
                        'redirect_url' => $redirectUrl
                    ]);
                    
                    // Perform direct header redirect instead of Laravel's redirect helper
                    header('Location: ' . $redirectUrl);
                    exit;
                    
                default:
                    return back()->with('error', 'Invalid payment method selected.');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error adding funds to wallet', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
} 