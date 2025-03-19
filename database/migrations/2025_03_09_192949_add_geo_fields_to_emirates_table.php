<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emirates', function (Blueprint $table) {
            $table->string('local_name')->nullable()->after('name');
            $table->decimal('latitude', 10, 8)->nullable()->after('local_name');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->json('boundary_coordinates')->nullable()->after('longitude');
            $table->boolean('is_active')->default(true)->after('boundary_coordinates');
            $table->softDeletes();

            // Add indexes
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::table('emirates', function (Blueprint $table) {
            $table->dropColumn(['local_name', 'latitude', 'longitude', 'boundary_coordinates', 'is_active']);
            $table->dropSoftDeletes();
            $table->dropIndex(['latitude', 'longitude']);
        });
    }
}; 