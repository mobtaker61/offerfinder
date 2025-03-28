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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();  // unique identifier like 'credit_card', 'paypal', etc.
            $table->string('display_name');    // Human-readable name for display
            $table->text('description')->nullable();
            $table->unsignedBigInteger('payment_gateway_id')->nullable();  // We'll add the foreign key constraint later
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->string('icon')->nullable();
            $table->json('settings')->nullable();  // configuration settings for the payment method
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
