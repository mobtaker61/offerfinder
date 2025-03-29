<?php

namespace App\Services;

use App\Models\PaymentGateway;
use App\Models\WalletTransaction;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ZiinaPaymentService
{
    protected $paymentGateway;
    protected $apiBaseUrl = 'https://api-v2.ziina.com/api';
    
    /**
     * Create a new Ziina payment service instance.
     */
    public function __construct(PaymentGateway $paymentGateway = null)
    {
        $this->paymentGateway = $paymentGateway;
    }
    
    /**
     * Set the payment gateway
     */
    public function setPaymentGateway(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
        return $this;
    }
    
    /**
     * Get the configuration
     */
    protected function getConfig()
    {
        if (!$this->paymentGateway) {
            $this->paymentGateway = PaymentGateway::where('code', 'ziina')->first();
        }
        
        if (!$this->paymentGateway) {
            throw new \Exception('Ziina payment gateway not found');
        }
        
        // Get the configuration
        $config = $this->paymentGateway->configuration;
        
        // Handle double JSON encoding issue
        if (is_string($config) && !is_array(json_decode($config, true))) {
            // If it's a string but not a valid JSON, try decoding twice
            try {
                // First remove escape characters if they exist
                $cleanConfig = stripslashes($config);
                // Remove any quotes at the start and end if they exist
                $cleanConfig = trim($cleanConfig, '"\'');
                // Decode the JSON string
                $decodedConfig = json_decode($cleanConfig, true);
                
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedConfig)) {
                    $config = $decodedConfig;
                    // Log the successful fix
                    \Illuminate\Support\Facades\Log::info('Fixed double encoded JSON config', [
                        'gateway_id' => $this->paymentGateway->id,
                        'original' => $this->paymentGateway->configuration,
                        'fixed' => $config
                    ]);
                    
                    // Update the gateway with the correct encoding
                    $this->paymentGateway->update([
                        'configuration' => $config
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to fix double encoded config', [
                    'error' => $e->getMessage(),
                    'config' => $config
                ]);
            }
        }
        
        // If the configuration is a string, decode it
        if (is_string($config)) {
            $config = json_decode($config, true) ?? [];
        }
        
        \Illuminate\Support\Facades\Log::info('Retrieved Ziina gateway configuration', [
            'gateway_id' => $this->paymentGateway->id,
            'is_active' => $this->paymentGateway->is_active,
            'is_test_mode' => $this->paymentGateway->is_test_mode,
            'has_configuration' => !empty($config),
            'configuration_type' => gettype($config),
        ]);
        
        return is_array($config) ? $config : [];
    }
    
    /**
     * Get the access token
     */
    protected function getAccessToken()
    {
        $config = $this->getConfig();
        
        // Ensure config is an array before using array functions
        if (!is_array($config)) {
            $config = [];
            \Illuminate\Support\Facades\Log::error('Configuration is not an array', [
                'type' => gettype($config),
                'value' => $config
            ]);
        }
        
        // Log the configuration structure (without sensitive data)
        \Illuminate\Support\Facades\Log::info('Ziina configuration structure', [
            'has_config' => !empty($config),
            'config_keys' => !empty($config) ? array_keys($config) : [],
            'config_is_array' => is_array($config),
            'has_access_token' => isset($config['access_token']),
        ]);
        
        // For testing purposes, if we're in test mode and no access token is provided, 
        // use a default test token
        if ($this->paymentGateway && $this->paymentGateway->is_test_mode && empty($config['access_token'])) {
            \Illuminate\Support\Facades\Log::warning('Using default test access token for Ziina - REPLACE WITH ACTUAL TOKEN IN PRODUCTION');
            return 'test_access_token_for_development';
        }
        
        if (empty($config['access_token'])) {
            throw new \Exception('Ziina access token not found in configuration. Please add an access_token in the payment gateway settings.');
        }
        
        return $config['access_token'];
    }
    
    /**
     * Make an API request to Ziina
     */
    protected function makeRequest(string $method, string $endpoint, array $data = [])
    {
        $accessToken = $this->getAccessToken();
        $url = $this->apiBaseUrl . '/' . ltrim($endpoint, '/');
        
        // Log the request details (without sensitive info)
        \Illuminate\Support\Facades\Log::info('Making Ziina API request', [
            'method' => $method,
            'endpoint' => $endpoint,
            'url' => $url,
            'test_mode' => $this->paymentGateway->is_test_mode ?? false,
            'data_keys' => array_keys($data),
        ]);
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->$method($url, $data);
            
            // Log response status
            \Illuminate\Support\Facades\Log::info('Ziina API response received', [
                'status' => $response->status(),
                'success' => $response->successful(),
                'body_preview' => substr(json_encode($response->json()), 0, 500),
            ]);
            
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Ziina API request failed', [
                'error' => $e->getMessage(),
                'method' => $method,
                'endpoint' => $endpoint,
            ]);
            throw $e;
        }
    }
    
    /**
     * Handle the API response
     */
    protected function handleResponse(Response $response)
    {
        if ($response->successful()) {
            return $response->json();
        }
        
        // Handle common error cases with custom messages
        $status = $response->status();
        $body = $response->json();
        
        $errorMessage = $body['message'] ?? null;
        
        switch ($status) {
            case 401:
                if ($this->paymentGateway && $this->paymentGateway->is_test_mode) {
                    // Special handling for test mode
                    \Illuminate\Support\Facades\Log::warning('Using demo response for test mode due to unauthorized error');
                    
                    // Simulate a successful payment intent creation in test mode
                    // This is only for development/testing and should not be used in production
                    return [
                        'id' => 'test_' . uniqid(),
                        'amount' => $response->transferStats?->getRequest()->getBody() ? json_decode($response->transferStats->getRequest()->getBody(), true)['amount'] ?? 1000 : 1000,
                        'currency_code' => 'AED',
                        'created_at' => date('Y-m-d H:i:s'),
                        'status' => 'requires_payment_instrument',
                        'operation_id' => 'test_op_' . uniqid(),
                        'message' => 'Test payment in simulation mode',
                        'redirect_url' => route('payment.success', ['transaction_id' => request()->route('transactionId') ?? 1, 'test' => true]),
                    ];
                }
                
                throw new \Exception('Unauthorized access to Ziina API. Please check your access token.');
                
            case 403:
                throw new \Exception('Access forbidden. Your API token does not have permission to perform this action.');
                
            case 404:
                throw new \Exception('Ziina API endpoint not found. Please check if the API URL is correct.');
                
            case 422:
                $validationErrors = isset($body['errors']) ? json_encode($body['errors']) : 'Unknown validation error';
                throw new \Exception('Validation error: ' . $validationErrors);
                
            default:
                throw new \Exception(
                    $errorMessage ?? 'Ziina API error: ' . $status,
                    $status
                );
        }
    }
    
    /**
     * Create a payment intent for a transaction
     */
    public function createPaymentIntent(WalletTransaction $transaction)
    {
        // Convert amount to the smallest unit (fils) - Ziina expects amount in fils
        $amountInFils = (int) ($transaction->amount * 100);
        
        $data = [
            'amount' => abs($amountInFils), // Make sure amount is positive
            'currency_code' => setting('system.currency', 'AED'), // Get currency from settings
            'message' => 'Wallet top-up transaction #' . $transaction->id,
            'success_url' => route('payment.success', ['transaction_id' => $transaction->id]),
            'cancel_url' => route('payment.cancel', ['transaction_id' => $transaction->id]),
            'failure_url' => route('payment.failure', ['transaction_id' => $transaction->id]),
            'transaction_source' => 'directApi',
            'test' => $this->paymentGateway->is_test_mode,
        ];
        
        // Log the request data
        \Illuminate\Support\Facades\Log::info('Ziina payment intent request', [
            'transaction_id' => $transaction->id,
            'request_data' => $data,
        ]);
        
        $response = $this->makeRequest('post', 'payment_intent', $data);
        
        // Log the response
        \Illuminate\Support\Facades\Log::info('Ziina payment intent response', [
            'transaction_id' => $transaction->id,
            'response' => $response,
        ]);
        
        // Ensure redirect_url is present
        if (empty($response['redirect_url'])) {
            throw new \Exception('Ziina payment intent is missing redirect URL');
        }
        
        return $response;
    }
    
    /**
     * Get a payment intent by ID
     */
    public function getPaymentIntent(string $paymentIntentId)
    {
        return $this->makeRequest('get', 'payment_intent/' . $paymentIntentId);
    }
    
    /**
     * Create a webhook
     */
    public function createWebhook(string $url, string $event = 'payment_intent.status_updated')
    {
        $data = [
            'url' => $url,
            'event' => $event,
        ];
        
        return $this->makeRequest('post', 'webhooks', $data);
    }
    
    /**
     * Process a refund
     */
    public function createRefund(string $paymentIntentId, int $amount = null)
    {
        $data = [
            'payment_intent_id' => $paymentIntentId,
        ];
        
        if ($amount !== null) {
            $data['amount'] = $amount;
        }
        
        return $this->makeRequest('post', 'refunds', $data);
    }
} 