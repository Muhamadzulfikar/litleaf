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
        Schema::create('novel_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('novel_uuid')->references('uuid')->on('novels')->cascadeOnDelete();
            $table->foreignId('genre_id')->references('id')->on('genre')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novel_genre');
    }
};
