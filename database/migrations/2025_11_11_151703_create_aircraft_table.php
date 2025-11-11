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
        Schema::create('aircraft', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->string('model'); // Boeing 737, Airbus A320, etc.
            $table->string('registration'); // PK-LHI, PK-GNF, etc.
            $table->integer('economy_seats')->default(0);
            $table->integer('business_seats')->default(0);
            $table->integer('first_class_seats')->default(0);
            $table->integer('total_seats');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft');
    }
};
