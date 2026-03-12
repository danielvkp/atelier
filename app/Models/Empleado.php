<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleado';

    protected $fillable = [
      'nombre',
      'tipo',
      'color'
    ];

    public function cita(){
      return $this->hasMany(Cita::class, 'empleado_id', 'id');
    }
}
