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
            $table->unsignedBigInteger('order_id');
            $table->string('payment_id')->nullable(); // stripe/paypal id
            $table->enum('method', ['cod', 'stripe', 'paypal', 'bank_transfer']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->text('response')->nullable(); // gateway response
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
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
