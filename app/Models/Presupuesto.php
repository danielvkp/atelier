<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'presupuesto';

    protected $fillable = [
      'cliente_id',
      'servicio_id',
      'empaquetado',
      'fecha_prevista',
      'elevador',
      'aparcamiento_origen',
      'aparcamiento_destino',
      'informacion',
      'observaciones',
      'precio',
      'aceptado',
      'nombre_archivo'
    ];

    protected $appends = [
      'fecha_creacionf',
      'fecha_previstaf',
      'path_archivo'
    ];

    protected $casts = [
      'aceptado' => 'boolean',
      'elevador' => 'boolean',
    ];

    public function getFechaCreacionfAttribute(){
      return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    public function getFechaPrevistafAttribute(){
      return $this->fecha_prevista ? Carbon::parse($this->fecha_prevista)->format('d-m-Y') : 'N/A';
    }

    public function getPathArchivoAttribute(){
      return asset("storage/presupuesto/{$this->nombre_archivo}");
    }

    public function servicio(){
      return $this->belongsTo(ClienteServicio::class, 'servicio_id', 'id');
    }

    public function cliente(){
      return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function item(){
      return $this->hasMany(PresupuestoItem::class);
    }

    public function historial(){
      return $this->hasMany(PresupuestoHistorial::class);
    }
  }
