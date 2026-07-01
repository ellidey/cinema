<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('row');
            $table->unsignedSmallInteger('number');
            $table->decimal('price', 10, 2);
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['hall_id', 'row', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
