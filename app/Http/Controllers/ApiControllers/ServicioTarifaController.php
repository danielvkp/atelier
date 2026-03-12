<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\ServicioTarifa;

class ServicioTarifaController extends Controller
{
    public function all(){
      $items = ServicioTarifa::whereHas('servicio')
        ->with('servicio:id,nombre')
        ->get(['id', 'servicio_id', 'tipo', 'duracion']);
      return response()->json($items, 200);
    }

    public function get($servicio_id){
      $items = ServicioTarifa::where('servicio_id', $servicio_id)->get();
      return response()->json($items, 200);
    }

    public function save($id, Request $request){
      $servicio = Servicio::find($id);

      $item = $servicio->tarifa()->updateOrCreate([
        'id' => $request->id
      ], $request->all());

      return response()->json($item, 200);
    }

    public function trash($id){
      $item = ServicioTarifa::find($id)->delete();
      return response()->json('eliminado', 200);
    }
}
