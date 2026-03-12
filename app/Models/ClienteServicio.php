<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicio extends Model
{
    use HasFactory;

    protected $table = 'cliente_servicio';

    protected $fillable = [
      'comercial_id',
      'cliente_id',
      'destino',
      'origen',
      'fecha_mudanza',
      'fecha_inicio',
      'fecha_final',
      'tamano',
      'detalles',
      'costo_estimado',
      'status',
      'calendario',
      'volumen',
      'personal',
      'duracion',
      'color_id'
    ];

    protected $appends = [
      'servicios_id'
    ];

    protected $casts = [
      'calendario' => 'boolean'
    ];

    public function comercial(){
      return $this->belongsTo(User::class, 'comercial_id');
    }

    public function cliente(){
      return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function historial(){
      return $this->hasMany(ClienteServicioHistorial::class);
    }

    public function direccion(){
      return $this->hasMany(ClienteServicioDireccion::class, 'cliente_servicio_id', 'id');
    }

    public function order_historial(){
      return $this->historial()->orderBy('fecha', 'DESC');
    }

    public function servicio_db(){
      return $this->belongsToMany(Servicio::class);
    }

    public function color(){
      return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function elevador(){
      return $this->hasMany(ClienteServicioElevador::class, 'cliente_servicio_id', 'id');
    }

    public function presupuesto(){
      return $this->hasMany(Presupuesto::class, 'servicio_id', 'id');
    }

    public function getServiciosIdAttribute(){
      return $this->servicio_db->pluck('id');
    }
}
