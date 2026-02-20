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
            $table->ulid('id')->primary();
            $table->string('order_number')->unique();
            $table->enum('order_type', ['takeaway', 'dine_in']);
            $table->enum('status', ['pending', 'paid', 'processing', 'ready', 'completed', 'cancelled']);
            $table->enum('payment_method', ['cash', 'midtrans_qris', 'midtrans_bank']);
            $table->enum('payment_status', ['unpaid', 'paid']);
            $table->integer('total_hpp');
            $table->integer('total_price');
            $table->foreignUlid('cashier_id')->nullable()->constrained('users')->nullOnDelete();
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
