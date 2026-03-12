<?php

namespace App\Helpers;

use App\Models\ClienteServicio;

class DireccionHelper {

  public function save(ClienteServicio $servicio, array $direccion){
    $servicio->direccion()->delete();

    foreach ($direccion as $key => $item) {
      $servicio->direccion()->create([
        'origen'           => $item['origen'],
        'elevador_origen'  => $item['elevador_origen'],
        'destino'          => $item['destino'],
        'elevador_destino' => $item['elevador_destino']
      ]);
    }
  }

  public function saveElevador(ClienteServicio $servicio, array $direccion){
    $servicio->elevador()->delete();

    foreach ($direccion as $key => $item) {
      $servicio->elevador()->create([
        'origen'  => $item['origen'],
        'destino' => $item['destino']
      ]);
    }
  }

}
