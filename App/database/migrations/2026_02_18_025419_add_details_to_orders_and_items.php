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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('table_number')->nullable()->after('order_type');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('notes')->nullable()->after('qty');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending')->after('unit_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('table_number');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropColumn('status');
        });
    }
};
