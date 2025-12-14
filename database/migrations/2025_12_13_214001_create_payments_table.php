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

            // Relatie naar user
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Relatie naar order
            $table->foreignId('order_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('amount', 12, 2); // Betalingsbedrag
            $table->string('currency', 3)->default('EUR'); // Valuta
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable(); // bv. 'credit_card', 'paypal'
            $table->dateTime('paid_at')->nullable();
            $table->json('metadata')->nullable(); // Optionele extra data, bv. transaction ID
            $table->timestamps();
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
