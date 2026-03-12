<?php

namespace App\Searchers;

use App\Models\Cliente;
use App\Models\ClienteServicio;
use Illuminate\Http\Request;
use App\Utils\ClienteServicioContants;
use Illuminate\Database\Eloquent\Builder;

class MudanzaSearch
{
  public static function apply(Request $filters){
      $items = (new ClienteServicio())->newQuery();

      $items->with(['cliente', 'comercial']);

      $items->whereHas('cliente', function (Builder $query) {
          $query->where('seguimiento', 'cerrado');
      });

      /*if($filters->filled('search')){
         $items->where('nombre', 'like', "%{$filters->search}%")
          ->orWhere('email', 'like', "%{$filters->search}%")
          ->orWhere('telefono', 'like', "%{$filters->search}%");
      }*/

      if($filters->filled('status')){
        $items->where('status', $filters->status);
      }

      return $items->orderBy('created_at', 'DESC')->paginate(50);
  }
}
