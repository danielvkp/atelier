<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'cita';

    protected $fillable = [
      'payment_id',
      'servicio_tarifa_id',
      'empleado_id',
      'fecha',
      'duracion',
      'hora',
      'full_date',
      'end',
      'status',
      'tipo',
      'status_consulta',
      'is_from_web'
    ];

    protected $casts = [
      'is_from_web' => 'boolean'
    ];

    public function payment(){
      return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function empleado(){
      return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }

    public function tarifa(){
      return $this->belongsTo(ServicioTarifa::class, 'servicio_tarifa_id', 'id');
    }
}
