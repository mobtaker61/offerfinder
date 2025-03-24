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
        Schema::table('offer_categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')
                  ->constrained('offer_categories')
                  ->nullOnDelete();
            $table->text('description')->nullable()->after('name');
            $table->string('slug')->unique()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'description', 'slug']);
        });
    }
};
