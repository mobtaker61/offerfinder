<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->constrained()->onDelete('cascade'); // Each branch belongs to a market
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('customer_service')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
