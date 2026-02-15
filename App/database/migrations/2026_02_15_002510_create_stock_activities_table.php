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
        Schema::create('stock_activities', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('stock_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type'); // 'created', 'updated', 'adjusted'
            $table->string('description');
            $table->json('changes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_activities');
    }
};
