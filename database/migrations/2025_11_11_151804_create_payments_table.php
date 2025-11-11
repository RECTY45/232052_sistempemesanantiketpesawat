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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('payment_code', 50)->unique(); // PAY123456
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['bank_transfer', 'credit_card', 'debit_card', 'e_wallet', 'virtual_account']);
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'cancelled'])->default('pending');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('reference_number')->nullable(); // Bank reference
            $table->datetime('payment_date')->nullable();
            $table->datetime('expires_at');
            $table->json('payment_details')->nullable(); // Store additional payment info
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['booking_id']);
            $table->index(['payment_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
