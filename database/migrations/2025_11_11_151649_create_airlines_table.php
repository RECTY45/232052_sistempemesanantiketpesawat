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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // IATA code like GA, JT, ID
            $table->string('name'); // Garuda Indonesia, Lion Air, etc.
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('country', 100)->default('Indonesia');
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};
