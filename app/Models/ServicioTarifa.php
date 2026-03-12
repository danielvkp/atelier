<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioTarifa extends Model
{
    use HasFactory;

    protected $table = 'servicio_tarifa';

    protected $fillable = [
      'servicio_id',
      'titulo',
      'contenido',
      'precio',
      'duracion',
      'tipo',
      'orden'
    ];

    public function servicio(){
      return $this->belongsTo(Servicio::class, 'servicio_id', 'id');
    }

    public function cita(){
      return $this->hasMany(Cita::class, 'servicio_tarifa_id', 'id');
    }
}
