<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
      'nro_orden',
      'nombre',
      'email',
      'telefono',
      'detalles',
      'status',
      'precio',
    ];

    public function cita(){
      return $this->hasOne(Cita::class, 'payment_id', 'id');
    }

    public function compra(){
      return $this->hasOne(Compra::class, 'payment_id', 'id');
    }
}
