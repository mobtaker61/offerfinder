<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();  // unique identifier like 'stripe', 'paypal', etc.
            $table->string('display_name');    // Human-readable name for display
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_test_mode')->default(true);  // sandbox/test mode or live mode
            $table->json('configuration')->nullable();    // configuration settings like API keys, etc.
            $table->timestamps();
        });
        
        // Now add the foreign key constraint to payment_methods
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key first
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign(['payment_gateway_id']);
        });
        
        Schema::dropIfExists('payment_gateways');
    }
};
