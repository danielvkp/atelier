<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\TestimonialFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonial';

    protected $fillable = [
      'nombre',
      'cargo',
      'rating',
      'descripcion',
    ];

    protected static function newFactory(){
      return TestimonialFactory::new();
    }
}
