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
        Schema::table('offer_products', function (Blueprint $table) {
            // Drop existing foreign key if it exists
            try {
                $table->dropForeign(['offer_image_id']);
            } catch (\Exception $e) {
                // Foreign key might not exist yet, continue
            }
            
            // Add foreign key with ON DELETE CASCADE
            $table->foreign('offer_image_id')
                  ->references('id')
                  ->on('offer_images')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_products', function (Blueprint $table) {
            // Drop the CASCADE foreign key
            try {
                $table->dropForeign(['offer_image_id']);
            } catch (\Exception $e) {
                // Foreign key might not exist, continue
            }
            
            // Add back a foreign key without cascade delete
            $table->foreign('offer_image_id')
                  ->references('id')
                  ->on('offer_images')
                  ->onDelete('set null');
        });
    }
};
