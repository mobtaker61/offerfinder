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
        Schema::create('settings_schema', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('group')->default('general');
            $table->enum('data_type', ['string', 'integer', 'boolean', 'float', 'array', 'object', 'file', 'image', 'email', 'url', 'text', 'select']);
            $table->text('options')->nullable()->comment('JSON string for select options or validation rules');
            $table->text('default_value')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_schema');
    }
};
