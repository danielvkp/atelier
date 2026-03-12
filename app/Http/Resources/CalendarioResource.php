<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CalendarioResource extends JsonResource
{
  public function toArray(Request $request): array {
        return [
          'id'           => $this->id,
          'start'        => $this->fecha_mudanza,
          'end'          => $this->fecha_mudanza,
          'color'        => $this->color()->exists() ? $this->color->hexa : 'blue',
          'allDay'       => false,
          'origen'       => $this->origen,
          'destino'      => $this->destino,
          'detalles'     => $this->detalles,
          'color_id'     => $this->color_id,
          'volumen'      => $this->volumen,
          'personal'     => $this->personal,
          'fecha_mudanza'=> Carbon::parse($this->fecha_mudanza)->format('Y-m-d'),
          $this->mergeWhen($this->cliente()->exists(), function() {
              return [
                'cliente_id'  => $this->cliente->id,
                'title'       => $this->cliente->nombre,
                'nombre'      => $this->cliente->nombre,
                'telefono'    => $this->cliente->telefono,
                'email'       => $this->cliente->email,
              ];
          }),

          $this->mergeWhen($this->direccion()->exists(), function() {
              return [
                'direccion'  => $this->direccion,
              ];
          }),

          $this->mergeWhen($this->comercial()->exists(), function() {
              return [
                'inicial'  => Str::substr($this->comercial->name, 0, 1),
              ];
          }),

          $this->mergeWhen($this->servicio_db()->exists(), function() {
              return [
                'servicios'  => $this->servicio_db,
              ];
          }),

        ];
    }
}
