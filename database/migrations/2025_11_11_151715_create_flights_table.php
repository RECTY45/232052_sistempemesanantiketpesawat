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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number', 20)->unique(); // GA123, JT456
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->foreignId('aircraft_id')->constrained()->onDelete('cascade');
            $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
            $table->integer('duration_minutes'); // Flight duration in minutes
            $table->decimal('economy_price', 10, 2)->default(0);
            $table->decimal('business_price', 10, 2)->default(0);
            $table->decimal('first_class_price', 10, 2)->default(0);
            $table->integer('available_economy_seats')->default(0);
            $table->integer('available_business_seats')->default(0);
            $table->integer('available_first_class_seats')->default(0);
            $table->enum('status', ['scheduled', 'delayed', 'cancelled', 'completed'])->default('scheduled');
            $table->string('gate')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['departure_airport_id', 'arrival_airport_id', 'departure_time'], 'flights_route_time_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
