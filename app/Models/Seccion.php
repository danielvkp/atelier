<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Storage;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'seccion';

    protected $fillable = [
      'titulo',
      'slug',
      'meta_keywords',
      'meta_contenido',
      'contenido',
      'imagen',
      'tipo',
    ];

    protected $appends = [
     'cover'
   ];

   public function getCoverAttribute(){
     return asset("storage/seccion/{$this->imagen}");
   }

    public function setImagenAttribute($img){
      if(!$img || !File::isFile($img)){
        return null;
      }
      $file_name = uniqid() . '-' . $img->getClientOriginalName();
      Storage::disk('seccion')->put($file_name,  File::get($img));
      $this->attributes['imagen'] = $file_name;
    }
}
