<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Storage;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';

    protected $fillable = [
      'nombre',
      'descripcion',
      'imagen',
      'precio',
      'slug',
      'contenido',
      'menu',
    ];

    protected $appends = [
     'cover'
   ];

   public function tarifa(){
     return $this->hasMany(ServicioTarifa::class)->orderBy('orden', 'DESC');
   }

   public function getCoverAttribute(){
     return asset("storage/servicio/{$this->imagen}");
   }

    public function setImagenAttribute($img){
      if(!$img || !File::isFile($img)){
        return null;
      }
      $file_name = uniqid() . '-' . $img->getClientOriginalName();
      Storage::disk('servicio')->put($file_name,  File::get($img));
      $this->attributes['imagen'] = $file_name;
    }

}
