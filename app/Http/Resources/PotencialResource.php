<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PotencialResource extends JsonResource
{
    public function toArray(Request $request): array{
        return [
          'id'          => $this->id,
          'nombre'      => $this->nombre,
          'telefono'    => $this->telefono,
          'email'       => $this->email,
          'status'      => $this->status,
          'seguimiento' => $this->seguimiento,
          $this->mergeWhen($this->ultimo_servicio()->exists(), function() {
              return [
                'fecha_mudanza'  => $this->ultimo_servicio->fecha_mudanza,
              ];
            }),
          $this->mergeWhen($this->fuente()->exists(), function() {
              return [
                'medio'   => $this->fuente->nombre,
                'tipo_medio'   => $this->fuente->tipo,
              ];
            }),
        ];
    }
}
