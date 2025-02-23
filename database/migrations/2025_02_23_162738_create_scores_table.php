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
        Schema::create('scores', function (Blueprint $table) {  
            $table->id(); // Kolom primary key  
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->float('score', 8, 2); // Kolom untuk menyimpan nilai dengan tipe float (8 digit total, 2 digit desimal)  
            $table->timestamps(); // Kolom untuk timestamps created_at dan updated_at  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
