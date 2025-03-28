<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the payment gateways.
     */
    public function index()
    {
        $paymentGateways = PaymentGateway::withCount('paymentMethods')
            ->orderBy('name')
            ->get();
            
        return view('admin.finance.payment_gateways.index', compact('paymentGateways'));
    }

    /**
     * Show the form for creating a new payment gateway.
     */
    public function create()
    {
        return view('admin.finance.payment_gateways.create');
    }

    /**
     * Store a newly created payment gateway in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_gateways,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'configuration' => 'nullable|json',
        ]);
        
        // Handle boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_test_mode'] = $request->has('is_test_mode');
        
        // Generate a code from name if not provided
        if (empty($validated['code'])) {
            $validated['code'] = Str::slug($validated['name']);
        }
        
        // Create the payment gateway
        PaymentGateway::create($validated);
        
        return redirect()->route('admin.finance.payment-gateways.index')
            ->with('success', 'Payment gateway created successfully');
    }

    /**
     * Display the specified payment gateway.
     */
    public function show(PaymentGateway $paymentGateway)
    {
        $paymentGateway->load('paymentMethods');
        
        return view('admin.finance.payment_gateways.show', compact('paymentGateway'));
    }

    /**
     * Show the form for editing the specified payment gateway.
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.finance.payment_gateways.edit', compact('paymentGateway'));
    }

    /**
     * Update the specified payment gateway in storage.
     */
    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_gateways,code,' . $paymentGateway->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'configuration' => 'nullable|json',
        ]);
        
        // Handle boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_test_mode'] = $request->has('is_test_mode');
        
        // Special handling for Ziina configuration
        if ($paymentGateway->code === 'ziina' && !empty($validated['configuration'])) {
            $config = json_decode($validated['configuration'], true);
            
            // Ensure configuration is valid
            if (json_last_error() === JSON_ERROR_NONE) {
                // Make sure the access_token exists
                if (empty($config['access_token']) && $validated['is_test_mode']) {
                    // If in test mode and no token, add a default test token
                    $config['access_token'] = 'test_access_token_for_development';
                    $validated['configuration'] = json_encode($config);
                }
            }
        }
        
        // Update the payment gateway
        $paymentGateway->update($validated);
        
        return redirect()->route('admin.finance.payment-gateways.index')
            ->with('success', 'Payment gateway updated successfully');
    }

    /**
     * Remove the specified payment gateway from storage.
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        // Check if the gateway is associated with any payment methods
        $methodsCount = $paymentGateway->paymentMethods()->count();
        
        if ($methodsCount > 0) {
            return redirect()->route('admin.finance.payment-gateways.index')
                ->with('error', "Cannot delete gateway. It's associated with {$methodsCount} payment methods.");
        }
        
        $paymentGateway->delete();
        
        return redirect()->route('admin.finance.payment-gateways.index')
            ->with('success', 'Payment gateway deleted successfully');
    }
    
    /**
     * Toggle the active status of the payment gateway.
     */
    public function toggleActive(PaymentGateway $paymentGateway)
    {
        $paymentGateway->is_active = !$paymentGateway->is_active;
        $paymentGateway->save();
        
        $status = $paymentGateway->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.finance.payment-gateways.index')
            ->with('success', "Payment gateway {$status} successfully");
    }
    
    /**
     * Toggle the test mode of the payment gateway.
     */
    public function toggleTestMode(PaymentGateway $paymentGateway)
    {
        $paymentGateway->is_test_mode = !$paymentGateway->is_test_mode;
        $paymentGateway->save();
        
        $mode = $paymentGateway->is_test_mode ? 'test' : 'live';
        
        return redirect()->route('admin.finance.payment-gateways.index')
            ->with('success', "Payment gateway switched to {$mode} mode successfully");
    }

    /**
     * Create a default Ziina payment gateway.
     */
    public function createDefaultZiina()
    {
        // Check if Ziina gateway already exists
        if (PaymentGateway::where('code', 'ziina')->exists()) {
            return redirect()->route('admin.finance.payment-gateways.index')
                ->with('info', 'Ziina payment gateway already exists.');
        }
        
        // Create default Ziina gateway with test configuration
        PaymentGateway::create([
            'name' => 'Ziina',
            'display_name' => 'Ziina Payment Gateway',
            'code' => 'ziina',
            'description' => 'Accept payments with Ziina payment gateway.',
            'is_active' => true,
            'is_test_mode' => true,
            'configuration' => json_encode([
                'access_token' => 'test_access_token_for_development',
                'webhook_url' => url('webhooks/ziina')
            ])
        ]);
        
        return redirect()->route('admin.finance.payment-gateways.index')
            ->with('success', 'Default Ziina payment gateway created successfully.');
    }
}
