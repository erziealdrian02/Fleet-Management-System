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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();  
            $table->string('question'); // Kolom untuk menyimpan soal  
            $table->string('option_a');  // Pilihan A  
            $table->string('option_b');  // Pilihan B  
            $table->string('option_c');  // Pilihan C  
            $table->string('option_d');  // Pilihan D  
            $table->string('correct_answer'); // Kolom untuk menyimpan jawaban yang benar  
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
