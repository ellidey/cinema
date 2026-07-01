<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserved_seats', function (Blueprint $table) {
            $table->id();
            $table->dateTime('reserved_at');
            $table->foreignId('seat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('showtime_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();

            $table->index(['showtime_id', 'status']);
            $table->unique(['seat_id', 'showtime_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserved_seats');
    }
};
