<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Storage;
use App\Helpers\ImageBaseHelper;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
      'nombre',
      'dni',
      'telefono',
      'telefono_dos',
      'email',
      'email_dos',
      'status',
      'seguimiento',
      'fuente_id',
      'firma'
    ];

    protected $appends = [
      'path_firma'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($cliente) {
             $cliente->servicio()->delete();
        });
    }

    public function servicio(){
      return $this->hasMany(ClienteServicio::class);
    }

    public function presupuesto(){
      return $this->hasMany(Presupuesto::class);
    }

    public function ultimo_servicio(){
      return $this->hasOne(ClienteServicio::class)->latest();
    }

    public function fuente(){
      return $this->belongsTo(Fuente::class, 'fuente_id', 'id');
    }

    public function getPathFirmaAttribute(){
      return storage_path("app/public/firma/{$this->firma}");
    }

    public function setFirmaAttribute($img){
      $imagen_helper = new ImageBaseHelper();

      $decode_image = $imagen_helper->createImageFromBase($img);

      if (!$decode_image){
           return null;
      }

      $this->attributes['firma'] = $decode_image['file_name'];

      Storage::disk('firma')->put($decode_image['file_name'], $decode_image['image']);
    }
}
