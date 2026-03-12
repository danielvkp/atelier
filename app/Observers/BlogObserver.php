<?php

namespace App\Observers;

use App\Models\Blog;
use Str;

class BlogObserver
{
  public function creating(Blog $item){
    $item->slug = Str::slug($item->titulo);
  }
}
