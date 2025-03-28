<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use App\Models\WalletTransaction;
use App\Services\ZiinaPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle payment initialization for Ziina
     */
    public function initializeZiinaPayment(Request $request, $transactionId)
    {
        try {
            $transaction = WalletTransaction::findOrFail($transactionId);
            
            // Check if transaction is already processed
            if ($transaction->status !== 'pending') {
                return redirect()->route('wallet.transactions')
                    ->with('error', 'This transaction has already been processed.');
            }
            
            // Get Ziina gateway
            $gateway = PaymentGateway::where('code', 'ziina')
                ->where('is_active', true)
                ->first();
                
            if (!$gateway) {
                Log::error('Ziina payment gateway not found or not active');
                return redirect()->route('wallet.transactions')
                    ->with('error', 'Payment gateway is not available. Please contact support.');
            }
            
            // Create payment service
            $ziinaService = new ZiinaPaymentService($gateway);
            
            // Check if we should use test mode simulation
            $useTestSimulation = $gateway->is_test_mode && config('app.env') !== 'production';
            
            // Create payment intent
            $paymentIntent = $ziinaService->createPaymentIntent($transaction);
            
            // Log successful payment intent creation
            Log::info('Payment intent created successfully', [
                'transaction_id' => $transactionId,
                'payment_intent_id' => $paymentIntent['id'] ?? 'unknown',
                'redirect_url' => $paymentIntent['redirect_url'] ?? 'missing',
                'is_test_simulation' => isset($paymentIntent['message']) && $paymentIntent['message'] === 'Test payment in simulation mode'
            ]);
            
            // Save payment intent ID to transaction for later reference
            $transaction->update([
                'reference_id' => $paymentIntent['id'],
                'meta_data' => [
                    'payment_intent' => $paymentIntent,
                    'gateway' => 'ziina',
                    'is_test_simulation' => $useTestSimulation
                ]
            ]);
            
            // Check if redirect URL is present
            if (empty($paymentIntent['redirect_url'])) {
                throw new \Exception('Payment gateway did not provide a redirect URL');
            }
            
            // For test requests with test param, immediately mark as successful
            if ($request->has('test') && $gateway->is_test_mode) {
                // Update transaction status to completed
                $transaction->update([
                    'status' => 'completed',
                    'balance_after' => $transaction->wallet->balance + $transaction->amount
                ]);
                
                // Update wallet balance
                $wallet = $transaction->wallet;
                $wallet->balance += $transaction->amount;
                $wallet->save();
                
                return redirect()->route('wallet.transactions')
                    ->with('success', 'Test payment completed successfully.');
            }
            
            // Redirect to Ziina payment page
            return redirect($paymentIntent['redirect_url']);
            
        } catch (\Exception $e) {
            Log::error('Ziina payment initialization failed: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Check for unauthorized error and offer solution
            if (strpos($e->getMessage(), 'Unauthorized') !== false) {
                return redirect()->route('wallet.transactions')
                    ->with('error', 'Payment initialization failed: Invalid API credentials. Please contact support or check the payment gateway configuration.');
            }
            
            return redirect()->route('wallet.transactions')
                ->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Handle successful payment
     */
    public function handleSuccess(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $transaction = WalletTransaction::findOrFail($transactionId);
        
        try {
            // If this is a test transaction (indicated by query parameter or in meta_data)
            $isTestTransaction = $request->has('test') || 
                                (isset($transaction->meta_data['is_test_simulation']) && $transaction->meta_data['is_test_simulation'] === true);
            
            // For test transactions, we can mark as completed immediately
            if ($isTestTransaction) {
                // Update transaction status if not already completed
                if ($transaction->status !== 'completed') {
                    Log::info('Marking test transaction as completed', ['transaction_id' => $transactionId]);
                    
                    // Update transaction status
                    $transaction->update([
                        'status' => 'completed',
                        'balance_after' => $transaction->wallet->balance + $transaction->amount
                    ]);
                    
                    // Update user wallet balance
                    $wallet = $transaction->wallet;
                    $wallet->balance += $transaction->amount;
                    $wallet->save();
                }
                
                return redirect()->route('wallet.transactions')
                    ->with('success', 'Test payment completed successfully.');
            }
            
            // Validate reference ID exists
            if (empty($transaction->reference_id)) {
                Log::error('Payment verification failed: Missing reference_id for transaction', [
                    'transaction_id' => $transactionId
                ]);
                
                return redirect()->route('wallet.transactions')
                    ->with('error', 'Payment reference ID is missing. Please contact support.');
            }
            
            // Get Ziina gateway
            $gateway = PaymentGateway::where('code', 'ziina')
                ->where('is_active', true)
                ->firstOrFail();
            
            // Create payment service
            $ziinaService = new ZiinaPaymentService($gateway);
            
            // Verify payment intent status
            $paymentIntent = $ziinaService->getPaymentIntent($transaction->reference_id);
            
            if ($paymentIntent['status'] === 'completed') {
                // Update transaction status
                $transaction->update([
                    'status' => 'completed',
                    'balance_after' => $transaction->wallet->balance + $transaction->amount,
                    'meta_data' => array_merge($transaction->meta_data ?? [], [
                        'payment_verification' => $paymentIntent,
                    ])
                ]);
                
                // Update user wallet balance
                $wallet = $transaction->wallet;
                $wallet->balance += $transaction->amount;
                $wallet->save();
                
                return redirect()->route('wallet.transactions')
                    ->with('success', 'Payment completed successfully.');
            } else {
                // Payment still in progress or failed
                return redirect()->route('wallet.transactions')
                    ->with('warning', 'Payment is still being processed. Status: ' . $paymentIntent['status']);
            }
            
        } catch (\Exception $e) {
            Log::error('Ziina payment verification failed: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('wallet.transactions')
                ->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Handle canceled payment
     */
    public function handleCancel(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $transaction = WalletTransaction::findOrFail($transactionId);
        
        // Update transaction status
        $transaction->update([
            'status' => 'canceled',
        ]);
        
        return redirect()->route('wallet.transactions')
            ->with('warning', 'Payment was canceled.');
    }
    
    /**
     * Handle failed payment
     */
    public function handleFailure(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $transaction = WalletTransaction::findOrFail($transactionId);
        
        // Update transaction status
        $transaction->update([
            'status' => 'failed',
        ]);
        
        return redirect()->route('wallet.transactions')
            ->with('error', 'Payment failed. Please try again or contact support.');
    }
    
    /**
     * Handle Ziina webhook
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Ziina webhook received', $payload);
        
        // Verify webhook signature if Ziina provides signature verification
        
        // Process the webhook event
        if (isset($payload['event']) && $payload['event'] === 'payment_intent.status_updated') {
            $paymentIntentId = $payload['data']['id'] ?? null;
            
            if ($paymentIntentId) {
                $transaction = WalletTransaction::where('reference_id', $paymentIntentId)->first();
                
                if ($transaction) {
                    $status = $payload['data']['status'] ?? null;
                    
                    switch ($status) {
                        case 'completed':
                            // Update transaction status
                            $transaction->update([
                                'status' => 'completed',
                                'meta_data' => array_merge($transaction->meta_data ?? [], [
                                    'webhook_data' => $payload,
                                ])
                            ]);
                            
                            // Update user wallet balance if not already done
                            if ($transaction->getOriginal('status') !== 'completed') {
                                $wallet = $transaction->wallet;
                                $wallet->balance += $transaction->amount;
                                $wallet->save();
                            }
                            break;
                            
                        case 'failed':
                            $transaction->update([
                                'status' => 'failed',
                                'meta_data' => array_merge($transaction->meta_data ?? [], [
                                    'webhook_data' => $payload,
                                ])
                            ]);
                            break;
                            
                        case 'canceled':
                            $transaction->update([
                                'status' => 'canceled',
                                'meta_data' => array_merge($transaction->meta_data ?? [], [
                                    'webhook_data' => $payload,
                                ])
                            ]);
                            break;
                    }
                }
            }
        }
        
        return response()->json(['status' => 'success']);
    }
} 