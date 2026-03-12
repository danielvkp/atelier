<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlacesPago extends Model
{
    use HasFactory;

    protected $table = 'enlaces_pago';

    protected $fillable = [
      'tipo',
      'titulo',
      'precio'
    ];
}
