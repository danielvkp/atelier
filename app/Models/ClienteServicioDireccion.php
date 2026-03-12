<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicioDireccion extends Model
{
    use HasFactory;

    protected $table = 'cliente_servicio_direccion';

    protected $fillable = [
      'cliente_servicio_id',
      'origen',
      'elevador_origen',
      'destino',
      'elevador_destino',
    ];

    public function servicio(){
      return $this->belongsTo(ClienteServicio::class, 'cliente_servicio_id', 'id');
    }
}
