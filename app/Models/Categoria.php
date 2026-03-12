<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';

    protected $fillable = [
      'nombre',
      'slug'
    ];

    public function blog(){
      return $this->belongsToMany(Blog::class);
    }
}
