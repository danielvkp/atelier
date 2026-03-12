<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationController extends Controller
{
    public function update(){
    /*  Schema::table('enlaces_pago', function (Blueprint $table) {
          $table->string('tipo')->after('id')->nullable()->default(NULL);
      });*/
      /*Schema::table('cita', function (Blueprint $table) {
        $table->integer('duracion')->after('fecha')->nullable()->default(NULL);
      });
      Schema::table('cita', function (Blueprint $table) {
          $table->datetime('end')->after('full_date')->nullable()->default(NULL);
      });
      Schema::table('empleado', function (Blueprint $table) {
          $table->string('color', 10)->after('tipo')->nullable()->default(NULL);
      });
      Schema::table('cita', function (Blueprint $table) {
          $table->integer('servicio_tarifa_id')->nullable()->default(NULL);
      });
      Schema::table('cita', function (Blueprint $table) {
          $table->boolean('is_from_web')->default(false)->after('servicio_tarifa_id');
      */
      Schema::table('servicio', function (Blueprint $table) {
          $table->string('menu')->after('contenido')->nullable()->default(NULL);
      });
      return 'success';
    }
}
