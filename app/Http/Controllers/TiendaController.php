<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\EnlacesPago;
use App\Mail\ProductoMail;
use Mail;

class TiendaController extends Controller
{
    public function testEmail(){
        Mail::to(env('ADMIN_EMAIL'))->send(new ProductoMail);
        return 'success';
    }

    public function confirmar($id){
      $item = Producto::where('id', $id)->get([
          'slug', 'id', 'nombre'
      ])->first();
      return view('tienda.confirmar_producto', compact('item'));
    }

    public function confirmarPago($tipo){
      $items = EnlacesPago::orderBy('precio', 'ASC')
        ->where('tipo', $tipo)
        ->get(['id', 'titulo', 'precio', 'tipo']);

      return view('tienda.confirmar_pago', compact('items'));
    }

    public function index(){
      $items = Producto::orderBy('created_at', 'DESC')->get([
        'slug', 'id', 'nombre', 'imagen', 'precio'
      ]);
      return view('tienda.tienda', compact('items'));
    }

    public function get($slug){
      $item = Producto::where('slug', $slug)->get([
          'slug', 'id', 'nombre', 'imagen', 'precio', 'contenido'
      ])->first();

      return view('tienda.producto', compact('item'));
    }
}
