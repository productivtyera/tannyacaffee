<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run this for SQLite if we need to do the table swap dance
        // But for consistency, we can do it for all drivers or check driver
        
        // 1. Create temp table with new schema including 'ready' status
        Schema::create('orders_temp', function (Blueprint $table) {
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

        // 2. Copy data from old table to new table
        // We use raw SQL to ensure all columns are copied matching by position or name
        // Since schema is identical except for the check constraint on status, 
        // and 'ready' data doesn't exist yet (that's why we are here), this copy is safe.
        DB::statement('INSERT INTO orders_temp SELECT * FROM orders');

        // 3. Drop old table
        Schema::drop('orders');

        // 4. Rename temp table to orders
        Schema::rename('orders_temp', 'orders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old schema without 'ready'
        Schema::create('orders_temp', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('order_number')->unique();
            $table->enum('order_type', ['takeaway', 'dine_in']);
            $table->enum('status', ['pending', 'paid', 'processing', 'completed', 'cancelled']);
            $table->enum('payment_method', ['cash', 'midtrans_qris', 'midtrans_bank']);
            $table->enum('payment_status', ['unpaid', 'paid']);
            $table->integer('total_hpp');
            $table->integer('total_price');
            $table->foreignUlid('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // We might lose data if any order had 'ready' status, but down migrations are destructive anyway for data that doesn't fit
        DB::statement('INSERT INTO orders_temp SELECT * FROM orders WHERE status != "ready"');

        Schema::drop('orders');
        Schema::rename('orders_temp', 'orders');
    }
};
