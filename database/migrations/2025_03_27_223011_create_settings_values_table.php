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
        Schema::create('settings_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_schema_id')->constrained('settings_schema')->onDelete('cascade');
            $table->text('value')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            
            // Ensure only one active value per setting
            $table->unique(['setting_schema_id', 'is_active'], 'unique_active_setting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_values');
    }
};
