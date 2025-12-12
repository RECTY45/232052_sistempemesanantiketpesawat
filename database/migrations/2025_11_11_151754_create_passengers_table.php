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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->enum('title', ['Mr', 'Ms', 'Mrs', 'Dr'])->default('Mr');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('nationality', 100)->default('Indonesian');
            $table->string('id_number')->nullable(); // KTP/Passport number
            $table->enum('id_type', ['ktp', 'passport', 'driving_license'])->default('ktp');
            $table->string('seat_number')->nullable(); // 12A, 15F, etc.
            $table->boolean('is_checked_in')->default(false);
            $table->datetime('checked_in_at')->nullable();
            $table->timestamps();

            $table->index(['booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
