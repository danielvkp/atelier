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
        Schema::create('orden', function (Blueprint $table) {
            $table->id();
            $table->string('nro_orden');
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono');
            $table->string('detalles');
            $table->date('fecha');
            $table->string('hora');
            $table->datetime('full_date');
            $table->string('status');
            $table->string('tipo');
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
        Schema::dropIfExists('orden');
    }
};
