<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicioHistorial extends Model
{
    use HasFactory;

    protected $table = 'cliente_servicio_historial';

    protected $fillable = [
      'cliente_servicio_id',
      'fecha',
      'detalles'
    ];

    public function setFechaAttribute($fecha){
      $this->attributes['fecha'] = substr($fecha,0,10);
    }

    public function cliente_servicio(){
      return $this->belongsTo(ClienteServicio::class, 'cliente_servicio_id');
    }
}
