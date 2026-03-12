<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Storage;
use Str;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';

    protected $fillable = [
      'nombre',
      'slug',
      'contenido',
      'short_contenido',
      'imagen',
      'archivo',
      'precio',
    ];

    protected $appends = [
      'cover',
    ];

   public function getCoverAttribute(){
     return asset("storage/producto/{$this->imagen}");
   }

   public function setImagenAttribute($img){
     if(!$img || !File::isFile($img)){
       return null;
     }
     $file_name = uniqid() . '-' . $img->getClientOriginalName();
     Storage::disk('producto')->put($file_name,  File::get($img));
     $this->attributes['imagen'] = $file_name;
   }

   public function setArchivoAttribute($img){
     if(!$img || !File::isFile($img)){
       return null;
     }

     $file_name = Str::slug($this->nombre) . '.pdf';
     Storage::disk('pdf')->put($file_name,  File::get($img));
     $this->attributes['archivo'] = $file_name;
   }
}
