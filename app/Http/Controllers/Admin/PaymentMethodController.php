<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the payment methods.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::with('paymentGateway')
            ->orderBy('display_order')
            ->get();
            
        return view('admin.finance.payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        $paymentGateways = PaymentGateway::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.finance.payment_methods.create', compact('paymentGateways'));
    }

    /**
     * Store a newly created payment method in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'nullable|string',
            'payment_gateway_id' => 'nullable|exists:payment_gateways,id',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
            'icon' => 'nullable|string|max:255',
            'settings' => 'nullable|json',
        ]);
        
        // Handle boolean value
        $validated['is_active'] = $request->has('is_active');
        
        // Generate a code from name if not provided
        if (empty($validated['code'])) {
            $validated['code'] = Str::slug($validated['name']);
        }
        
        // Create the payment method
        PaymentMethod::create($validated);
        
        return redirect()->route('admin.finance.payment-methods.index')
            ->with('success', 'Payment method created successfully');
    }

    /**
     * Display the specified payment method.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        $paymentMethod->load('paymentGateway');
        
        return view('admin.finance.payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified payment method.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        $paymentGateways = PaymentGateway::orderBy('name')->get();
        
        return view('admin.finance.payment_methods.edit', compact('paymentMethod', 'paymentGateways'));
    }

    /**
     * Update the specified payment method in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'description' => 'nullable|string',
            'payment_gateway_id' => 'nullable|exists:payment_gateways,id',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
            'icon' => 'nullable|string|max:255',
            'settings' => 'nullable|json',
        ]);
        
        // Handle boolean value
        $validated['is_active'] = $request->has('is_active');
        
        // Update the payment method
        $paymentMethod->update($validated);
        
        return redirect()->route('admin.finance.payment-methods.index')
            ->with('success', 'Payment method updated successfully');
    }

    /**
     * Remove the specified payment method from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // Check if the payment method is being used in any transactions
        $transactionsCount = $paymentMethod->transactions()->count();
        
        if ($transactionsCount > 0) {
            return redirect()->route('admin.finance.payment-methods.index')
                ->with('error', "Cannot delete payment method. It's used in {$transactionsCount} transactions.");
        }
        
        $paymentMethod->delete();
        
        return redirect()->route('admin.finance.payment-methods.index')
            ->with('success', 'Payment method deleted successfully');
    }
    
    /**
     * Toggle the active status of the payment method.
     */
    public function toggleActive(PaymentMethod $paymentMethod)
    {
        $paymentMethod->is_active = !$paymentMethod->is_active;
        $paymentMethod->save();
        
        $status = $paymentMethod->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.finance.payment-methods.index')
            ->with('success', "Payment method {$status} successfully");
    }
}
