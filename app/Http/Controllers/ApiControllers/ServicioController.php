<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function all(){
      return response()->json(Servicio::orderBy('created_at', 'DESC')->get(), 200);
    }

    public function get($id){
      $item = Servicio::with('tarifa')
        ->where('id', $id)
        ->get()
        ->first();

      return response()->json($item, 200);
    }

    public function save(Request $request){
      $blog = Servicio::updateOrCreate(['id' => $request->id], $request->all());
      return response()->json($blog, 200);
    }

    public function trash($id){
      $blog = Servicio::find($id)->delete();
      return response()->json('eliminado', 200);
    }
}
