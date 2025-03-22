<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First check if the table exists
        if (!Schema::hasTable('offer_products')) {
            return;
        }

        // Get the list of foreign keys
        $foreignKeys = $this->listTableForeignKeys('offer_products');
        
        Schema::table('offer_products', function (Blueprint $table) use ($foreignKeys) {
            // Drop existing foreign key if it exists
            if (in_array('offer_products_offer_image_id_foreign', $foreignKeys)) {
                $table->dropForeign('offer_products_offer_image_id_foreign');
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
        if (!Schema::hasTable('offer_products')) {
            return;
        }

        // Get the list of foreign keys
        $foreignKeys = $this->listTableForeignKeys('offer_products');
        
        Schema::table('offer_products', function (Blueprint $table) use ($foreignKeys) {
            // Drop the CASCADE foreign key if it exists
            if (in_array('offer_products_offer_image_id_foreign', $foreignKeys)) {
                $table->dropForeign('offer_products_offer_image_id_foreign');
            }
            
            // Add back a foreign key without cascade delete
            $table->foreign('offer_image_id')
                  ->references('id')
                  ->on('offer_images')
                  ->onDelete('set null');
        });
    }

    /**
     * Get list of foreign keys for a table
     */
    private function listTableForeignKeys(string $table): array
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
};
