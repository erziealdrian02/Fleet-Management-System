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
        Schema::create('part_request_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_request')->constrained('part_requests')->onDelete('cascade');
            $table->foreignId('id_parts')->constrained('spare_parts')->onDelete('cascade');
            $table->integer('quantity')->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_request_details');
    }
};
