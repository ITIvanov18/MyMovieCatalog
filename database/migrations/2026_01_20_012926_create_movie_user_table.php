<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
            Schema::create('movie_user', function (Blueprint $table) {
                $table->id();
                
                // връзка с потребителя
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                
                // връзка с филма
                $table->foreignId('movie_id')->constrained()->onDelete('cascade');
                
                // тип на списъка: 'watchlist', 'favorite', 'watched'
                $table->string('type'); 

                $table->timestamps();

                // уникален индекс: Един потребител не може да добави един филм 
                // два пъти в ЕДИН И СЪЩ списък (но може да е едновременно във favorite и watched)
                $table->unique(['user_id', 'movie_id', 'type']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_user');
    }
};
