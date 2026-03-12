<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Storage;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $fillable = [
      'meta_keywords',
      'meta_contenido',
      'visitas',
      'titulo',
      'slug',
      'autor',
      'cotenido',
      'imagen',
      'created_at'
    ];

    protected $appends = [
     'cover',
     'categorias'
   ];

   public function getCoverAttribute(){
     return asset("storage/blog/{$this->imagen}");
   }

     public function getCategoriasAttribute(){
       return $this->categoria->pluck('id');
     }

    public function setImagenAttribute($img){
      if(!$img || !File::isFile($img)){
        return null;
      }
      $file_name = uniqid() . '-' . $img->getClientOriginalName();
      Storage::disk('blog')->put($file_name,  File::get($img));
      $this->attributes['imagen'] = $file_name;
    }

    public function setCategoriaIdAttribute($categoria_id){
      $this->attributes['categoria_id'] = 1;
    }

    public function categoria(){
      return $this->belongsToMany(Categoria::class);
    }
}
