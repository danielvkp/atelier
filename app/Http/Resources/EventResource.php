<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EventResource extends JsonResource
{
    /*Aqui llega el modelo CITA*/
    public function toArray(Request $request): array{
      return [
          'id'          => $this->id,
          'start'       => $this->full_date,
          'end'         => $this->end,
          'hora'        => $this->hora,
          'status'      => $this->status_consulta,
          'allDay'      => false,
          'empleado_id' => $this->empleado()->exists() ? $this->empleado->id : null,
          'tipo'        => $this->tipo,
          'fecha'       => $this->fecha,
          'edit'        => $this->is_from_web,
          $this->mergeWhen($this->payment()->exists(), function() {
            return [
              'title'    => $this->payment->nombre,
              'nombre'   => $this->payment->nombre,
              'email'    => $this->payment->email,
              'telefono' => $this->payment->telefono,
              'pagado'   => $this->payment->status,
            ];
        }),

        $this->mergeWhen($this->empleado()->exists(), function() {
          return [
            'empleado'  => $this->empleado->nombre,
            'tipo_e'    => $this->empleado->tipo,
            'color'     => $this->empleado->color,
          ];
        }),

        $this->mergeWhen($this->tarifa()->exists(), function() {
          return [
            'servicio_tarifa_id' => $this->tarifa->id
          ];
        })
      ];
    }
}
