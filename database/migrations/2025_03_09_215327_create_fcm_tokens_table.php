<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fcm_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); // Optional for user tracking
            $table->string('token');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('fcm_tokens');
    }
    
};
