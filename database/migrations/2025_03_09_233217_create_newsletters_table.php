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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('content'); // HTML content
            $table->boolean('sent')->default(false); // Status if newsletter was sent
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('newsletters');
    }    
};
