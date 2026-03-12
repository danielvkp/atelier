<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legal as Servicio;

class LegalController extends Controller
{
  public function get(){
    return response()->json(Servicio::get()->last(), 200);
  }

  public function save(Request $request){
    $blog = Servicio::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($blog, 200);
  }
}
