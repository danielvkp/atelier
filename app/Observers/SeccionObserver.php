<?php

namespace App\Observers;

use App\Models\Seccion;
use Str;

class SeccionObserver
{
  public function creating(Seccion $item){
    $item->slug = Str::slug($item->titulo);
  }
}
