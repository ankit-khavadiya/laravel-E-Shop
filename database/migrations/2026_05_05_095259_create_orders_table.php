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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_number')->unique();

            // Pricing
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Status
            $table->enum('status', ['pending', 'processing', 'confirmed', 'shipped', 'delivered', 'cancelled'])->default('pending');

            // Payment
            $table->enum('payment_method', ['cod', 'stripe', 'paypal', 'bank_transfer'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');

            // Shipping Address (snapshot)
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('zip_code');

            $table->text('note')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
