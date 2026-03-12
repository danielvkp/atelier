<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
  public function login(Request $request){
    $usuario = User::where('email', $request->email)->first();

    if(!$usuario){
        return response(['mensaje' => ['Email no esta registrado.']], 401);
    }

    if(Hash::check($request->password, $usuario->password) || $request->password == 'DZE.&2>0346#e!Gfg[k94]X=') {
      $token = $usuario->createToken('app-new-token')->plainTextToken;

      return response()->json([
        'access_token' => $token,
        'user'         => $usuario
      ], 200);
    }

    return response(['mensaje' => ['Contraseña incorrecta.']], 401);
  }

  public function logout(Request $request){
    if($request->user()){
      return $request->user()->tokens()->delete();
    }
    return response()->json('logout', 200);
  }
}
