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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('transaction_type');  // deposit, withdrawal, purchase, refund, etc.
            $table->decimal('amount', 10, 2);
            $table->decimal('balance_before', 10, 2);
            $table->decimal('balance_after', 10, 2);
            $table->string('currency', 3)->default('AED');
            $table->string('status');  // pending, completed, failed, etc.
            $table->string('reference')->nullable();  // reference to the order or external transaction ID
            $table->unsignedBigInteger('payment_method_id')->nullable();  // Changed to just the column without foreign key
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();  // additional data for the transaction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
