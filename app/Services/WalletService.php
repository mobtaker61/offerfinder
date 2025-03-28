<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletService
{
    /**
     * Get or create a wallet for a user
     *
     * @param int|User $user
     * @param string $currency
     * @return Wallet
     */
    public function getOrCreateWallet($user, string $currency = 'AED'): Wallet
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['currency' => $currency, 'balance' => 0, 'is_active' => true]
        );
        
        return $wallet;
    }
    
    /**
     * Add funds to a user's wallet
     *
     * @param int|User $user
     * @param float $amount
     * @param string $transactionType
     * @param string $status
     * @param string|null $reference
     * @param int|null $paymentMethodId
     * @param string|null $description
     * @param array|null $metadata
     * @return WalletTransaction|null
     */
    public function addFunds(
        $user,
        float $amount,
        string $transactionType = 'deposit',
        string $status = 'completed',
        ?string $reference = null,
        ?int $paymentMethodId = null,
        ?string $description = null,
        ?array $metadata = null
    ): ?WalletTransaction {
        return $this->createTransaction(
            $user,
            $amount,
            $transactionType,
            $status,
            $reference,
            $paymentMethodId,
            $description,
            $metadata
        );
    }
    
    /**
     * Deduct funds from a user's wallet
     *
     * @param int|User $user
     * @param float $amount
     * @param string $transactionType
     * @param string $status
     * @param string|null $reference
     * @param int|null $paymentMethodId
     * @param string|null $description
     * @param array|null $metadata
     * @return WalletTransaction|null
     */
    public function deductFunds(
        $user,
        float $amount,
        string $transactionType = 'withdrawal',
        string $status = 'completed',
        ?string $reference = null,
        ?int $paymentMethodId = null,
        ?string $description = null,
        ?array $metadata = null
    ): ?WalletTransaction {
        return $this->createTransaction(
            $user,
            -$amount, // Negative amount for deduction
            $transactionType,
            $status,
            $reference,
            $paymentMethodId,
            $description,
            $metadata
        );
    }
    
    /**
     * Create a wallet transaction
     *
     * @param int|User $user
     * @param float $amount
     * @param string $transactionType
     * @param string $status
     * @param string|null $reference
     * @param int|null $paymentMethodId
     * @param string|null $description
     * @param array|null $metadata
     * @return WalletTransaction|null
     */
    private function createTransaction(
        $user,
        float $amount,
        string $transactionType,
        string $status,
        ?string $reference = null,
        ?int $paymentMethodId = null,
        ?string $description = null,
        ?array $metadata = null
    ): ?WalletTransaction {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        
        // Get or create the user's wallet
        $wallet = $this->getOrCreateWallet($user);
        
        if (!$wallet->is_active) {
            Log::error("Attempted transaction on inactive wallet. User ID: {$user->id}");
            return null;
        }
        
        try {
            $transaction = DB::transaction(function () use ($wallet, $user, $amount, $transactionType, $status, $reference, $paymentMethodId, $description, $metadata) {
                // Lock the wallet for update to prevent race conditions
                $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
                
                $balanceBefore = $wallet->balance;
                $balanceAfter = $balanceBefore + $amount;
                
                // Check if the balance would go negative for deductions
                if ($balanceAfter < 0 && $amount < 0) {
                    throw new \Exception("Insufficient funds in wallet. User ID: {$user->id}, Current Balance: {$balanceBefore}, Attempted Deduction: " . abs($amount));
                }
                
                // Update the wallet balance
                $wallet->balance = $balanceAfter;
                $wallet->save();
                
                // Create the transaction record
                $transaction = new WalletTransaction([
                    'wallet_id' => $wallet->id,
                    'user_id' => $user->id,
                    'transaction_type' => $transactionType,
                    'amount' => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'currency' => $wallet->currency,
                    'status' => $status,
                    'reference' => $reference,
                    'payment_method_id' => $paymentMethodId,
                    'description' => $description,
                    'metadata' => $metadata ? json_encode($metadata) : null,
                ]);
                
                $transaction->save();
                
                return $transaction;
            });
            
            return $transaction;
        } catch (\Exception $e) {
            Log::error("Error creating wallet transaction: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get user's wallet balance
     *
     * @param int|User $user
     * @return float
     */
    public function getBalance($user): float
    {
        $wallet = $this->getOrCreateWallet($user);
        return $wallet->balance;
    }
    
    /**
     * Check if a user has sufficient funds
     *
     * @param int|User $user
     * @param float $amount
     * @return bool
     */
    public function hasSufficientFunds($user, float $amount): bool
    {
        return $this->getBalance($user) >= $amount;
    }
    
    /**
     * Get user's transaction history
     *
     * @param int|User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTransactionHistory($user, int $limit = 10)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        
        return WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
} 