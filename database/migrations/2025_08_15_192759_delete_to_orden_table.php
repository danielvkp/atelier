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
        Schema::table('orden', function (Blueprint $table) {
          $table->dropColumn('fecha');
          $table->dropColumn('hora');
          $table->dropColumn('full_date');
          $table->dropColumn('duracion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden', function (Blueprint $table) {
            //
        });
    }
};
