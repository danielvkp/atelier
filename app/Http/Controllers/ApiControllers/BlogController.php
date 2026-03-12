<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog as Servicio;

class BlogController extends Controller
{
    public function all(){
      return response()->json(Servicio::orderBy('created_at', 'DESC')->get([
        'id', 'imagen', 'slug', 'titulo'
      ]), 200);
    }

    public function get($id){
      return response()->json(Servicio::find($id)->load('categoria'), 200);
    }

    public function save(Request $request){
      $blog = Servicio::updateOrCreate(['id' => $request->id], $request->except(['categoria', 'categorias']));
      $categorias = explode(',', $request->categorias);
      $blog->categoria()->sync($categorias);
      return response()->json($blog, 200);
    }

    public function trash($id){
      $blog = Servicio::find($id)->delete();
      return response()->json('eliminado', 200);
    }
}
