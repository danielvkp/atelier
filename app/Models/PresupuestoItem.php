<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoItem extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_item';

    protected $fillable = [
      'presupuesto_id',
      'sala',
      'descripcion',
      'cajas',
      'tipo',
    ];

    public function presupuesto(){
      return $this->belongsTo(Presupuesto::class, 'presupuesto_id', 'id');
    }
}
