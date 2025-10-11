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
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_id')->unique();
            $table->dateTime('payment_date');
            $table->string('payment_reference')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('payment_method'); //bank_transfer, ewallet, credit_card, cod
            $table->string('payment_status')->default('pending'); //pending, paid, failed, refunded
            $table->string('refund_reason')->nullable();
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
