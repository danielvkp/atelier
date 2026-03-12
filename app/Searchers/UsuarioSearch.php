<?php

namespace App\Searchers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioSearch
{
  public static function apply(Request $filters){
      $user = (new User())->newQuery();

      if($filters->filled('search')){
         $user->where('name', 'like', "%{$filters->search}%")
          ->orWhere('email', 'like', "%{$filters->search}%");
      }

      return $user->orderBy('created_at', 'DESC')->paginate(30);
  }
}
