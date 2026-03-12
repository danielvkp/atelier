<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Storage;

class Portafolio extends Model
{
    use HasFactory;

    protected $table = 'portafolio';

    protected $fillable = [
      'nombre',
      'url',
      'imagen',
      'color'
    ];

    protected $appends = [
     'cover'
   ];

   public function getCoverAttribute(){
     return asset("storage/portafolio/{$this->imagen}");
   }

    public function setImagenAttribute($img){
      if(!$img || !File::isFile($img)){
        return null;
      }
      $file_name = uniqid() . '-' . $img->getClientOriginalName();
      Storage::disk('portafolio')->put($file_name,  File::get($img));
      $this->attributes['imagen'] = $file_name;
    }
}
