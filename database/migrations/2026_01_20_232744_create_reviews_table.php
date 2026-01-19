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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // кой е написал ревюто?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // за кой филм е?
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            // самото ревю
            $table->text('content');
            // оценката (1 до 5)
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
