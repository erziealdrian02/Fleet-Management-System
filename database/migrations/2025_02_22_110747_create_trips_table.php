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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->string('no_sppd');
            $table->string('start_location');
            $table->string('end_location');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->float('distance')->default(0);
            $table->enum('status', ['Finish', 'Pending', 'Traficking', 'Crash', 'On Going'])->default('Aktif');
            $table->foreignId('route_id')->nullable()->constrained('routes')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
