<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoHistorial extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_historial';

    protected $fillable = [
      'user_id',
      'presupuesto_id',
      'archivo'
    ];

    protected $appends = [
      'path_archivo'
    ];

    public function getPathArchivoAttribute(){
      return asset("storage/presupuesto/{$this->archivo}");
    }

    public function presupuesto(){
     return $this->belongsTo(Presupuesto::class, 'presupuesto_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
