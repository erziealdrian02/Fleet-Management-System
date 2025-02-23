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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->unique();
            $table->string('type');
            $table->enum('status', ['Aktif', 'Perawatan', 'Rusak'])->default('Aktif');
            $table->integer('fuel_capacity');
            $table->date('last_service_date')->nullable();
            $table->float('mileage')->default(0);
            $table->boolean('gps_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
