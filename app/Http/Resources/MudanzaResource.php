<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MudanzaResource extends JsonResource
{

    public function toArray(Request $request): array {
      return [
        'id'              => $this->id,
        'fecha_mudanza'   => $this->fecha_mudanza,
        
        $this->mergeWhen($this->cliente()->exists(), function() {
            return [
              'cliente_id'  => $this->cliente->id,
              'nombre'      => $this->cliente->nombre,
              'telefono'    => $this->cliente->telefono,
              'email'       => $this->cliente->email,
            ];
        }),

        $this->mergeWhen($this->comercial()->exists(), function() {
              return [
                'comercial' => $this->comercial->name,
              ];
          }),
      ];
    }
}
