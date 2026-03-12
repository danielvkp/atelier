<?php

namespace App\Observers;

use App\Models\Categoria;
use Str;

class CategoriaObserver
{
  public function saving(Categoria $item){
    $item->slug = Str::slug($item->nombre);
  }
}
