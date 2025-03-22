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
        Schema::create('offer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('offer_image_id')->nullable();
            $table->string('variant')->nullable()->comment('Weight/Value/Type of product variant');
            $table->string('unit')->nullable()->comment('Unit of measurement (kg, g, pcs, etc)');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('extracted_data')->nullable()->comment('Original extracted data from AI');
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('offer_image_id')->references('id')->on('offer_images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_products');
    }
};
