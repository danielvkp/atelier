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
        Schema::create('servicio_tarifa', function (Blueprint $table) {
            $table->id();
            $table->integer('servicio_id');
            $table->string('titulo')->nullable()->default(NULL);
            $table->text('contenido')->nullable()->default(NULL);
            $table->double('precio', 13, 2)->default(0);
            $table->integer('duracion')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_tarifa');
    }
};
