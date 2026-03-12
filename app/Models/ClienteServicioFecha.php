<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicioFecha extends Model
{
    use HasFactory;

    protected $table = 'cliente_servicio_fecha';

    protected $fillable = [
      'cliente_servicio_id',
      'fecha'
    ];

    protected $casts = [
      'fecha' => 'date:Y-m-d'
    ];

    public function servicio(){
      return $this->belongsTo(ClienteServicio::class, 'cliente_servicio_id', 'id');
    }
}
