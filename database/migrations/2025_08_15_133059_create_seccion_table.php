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
        Schema::create('seccion', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('slug')->nullable()->default(NULL);
            $table->string('meta_keywords')->nullable()->default(NULL);
            $table->string('meta_contenido')->nullable()->default(NULL);
            $table->text('contenido');
            $table->string('imagen')->nullable()->default(NULL);
            $table->string('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seccion');
    }
};
