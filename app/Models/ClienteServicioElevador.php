<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicioElevador extends Model
{
    use HasFactory;

    protected $table = 'cliente_servicio_elevador';

    protected $fillable = [
      'origen',
      'destino'
    ];

    public function servicio(){
      return $this->belongsTo(ClienteServicio::class, 'cliente_servicio_id', 'id');
    }
}
