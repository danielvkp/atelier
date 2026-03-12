<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'orden';

    protected $fillable = [
      'nro_orden',
      'empleado_id',
      'nombre',
      'email',
      'telefono',
      'detalles',
      'status',
      'precio',
      'duracion',
      'fecha',
      'hora',
      'full_date',
      'tipo',
    ];
}
