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
        Schema::create('plan_feature_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('feature_type_id')->constrained()->onDelete('cascade');
            $table->string('value'); // Will store integer/boolean/string based on feature_type's value_type
            $table->timestamps();
            
            // Ensure a feature can only have one value per plan
            $table->unique(['plan_id', 'feature_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_feature_values');
    }
};
