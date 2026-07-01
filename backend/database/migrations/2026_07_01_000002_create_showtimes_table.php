<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('starts_at');
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->index('starts_at');
            $table->unique(['starts_at', 'hall_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
