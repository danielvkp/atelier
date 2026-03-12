<?php

namespace App\Searchers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Utils\ClienteStatusContants;

class PotencialSearch
{
  public static function apply(Request $filters){
      $items = (new Cliente())->newQuery();

      $items->with(['ultimo_servicio', 'fuente']);

      $items->where('status', ClienteStatusContants::POTENCIAL);

      if($filters->filled('search')){
         $items->where('nombre', 'like', "%{$filters->search}%")
          ->orWhere('email', 'like', "%{$filters->search}%")
          ->orWhere('telefono', 'like', "%{$filters->search}%");
      }

      if($filters->filled('seguimiento')){
         $items->where('seguimiento', 'like', "%{$filters->seguimiento}%");
      }

      return $items->orderBy('created_at', 'DESC')->paginate(50);
  }
}
