<?php

namespace App\Observers;

use App\Models\Servicio;
use Str;

class ServicioObserver
{
    public function saving(Servicio $servicio){
      $servicio->slug = Str::slug($servicio->nombre);
    }
}
