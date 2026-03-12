<?php

namespace App\Observers;

use App\Models\Producto;
use Str;

class ProductoObserver
{
  public function creating(Producto $item){
    $item->slug = Str::slug($item->nombre);
  }
}
