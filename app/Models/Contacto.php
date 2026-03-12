<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contacto';

    protected $fillable = [
      'plan_id',
      'nombre',
      'email',
      'telefono'
    ];

    public function plan(){
      return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

}
