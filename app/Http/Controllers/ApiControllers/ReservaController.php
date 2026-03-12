<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Payment;
use App\Models\ServicioTarifa;
use App\Http\Requests\CitaRequest;
use App\Http\Resources\EventResource;
use Carbon\Carbon;

class ReservaController extends Controller
{
  public function get(){
    $items = Cita::with(['payment', 'empleado', 'tarifa'])
      ->whereHas('payment')
      ->where('status', 'COMPLETADO')
      ->orderBy('full_date')
      ->get();
    $items_r = EventResource::collection($items);
    return response()->json($items_r, 200);
  }

  public function delete_reserva($id){
    $cita = Cita::find($id);
    $cita->delete();
    return response()->json('Cita eliminada con exito', 200);
  }

  public function save(CitaRequest $request){
      $existe_cita = $this->get_cita($request);

      if($existe_cita){
        return response()->json('Ya existe cita para este dia y hora', 301);
      }

      $tarifa = ServicioTarifa::where('id', $request->servicio_tarifa_id)
        ->get(['id', 'duracion', 'tipo'])
        ->first();

      $payment = Payment::create([
        'nro_orden' => date('is') . mt_rand(100, 999),
        'nombre'    => $request->nombre,
        'email'     => $request->email,
        'telefono'  => $request->telefono,
        'detalles'  => 'Reserva desde el calendario de administracion',
        'status'    => 'PENDIENTE',
        'precio'    => 1,
        'tipo'      => 'cita'
      ]);


      $full_carbon_date = $this->create_full_date($request->fecha, $request->hora);

      $payment->cita()->create([
        'empleado_id' => $request->empleado_id,
        'duracion'    => $tarifa->duracion,
        'fecha'       => Carbon::createFromDate($request->fecha)->format('Y-m-d'),
        'hora'        => $request->hora,
        'full_date'   => $full_carbon_date,
        'end'         => $full_carbon_date->copy()->addMinutes($tarifa->duracion),
        'status'      => 'COMPLETADO',
        'tipo'        => $tarifa->tipo,
        'status_consulta'    => 'PENDIENTE',
        'servicio_tarifa_id' => $tarifa->id,
        'is_from_web'        => false
      ]);

      return response()->json('Creado con exito!', 200);

  }

  public function update(Request $request, $id){
    $tarifa = ServicioTarifa::where('id', $request->servicio_tarifa_id)
      ->get(['id', 'duracion'])
      ->first();

    $existe_cita = $this->get_cita($request);

    if($existe_cita){
      return response()->json('Ya existe cita para este dia y hora', 301);
    }

    $item = Cita::find($id);
    $item->empleado_id = $request->empleado_id;
    $item->hora = $request->hora;
    $item->status_consulta = $request->status;
    $item->servicio_tarifa_id = $request->servicio_tarifa_id;
    $item->fecha = Carbon::createFromDate($request->fecha)->format('Y-m-d');
    $full_carbon_date = $this->create_full_date($request->fecha, $request->hora);
    $item->full_date = $full_carbon_date;
    $item->end = $full_carbon_date->copy()->addMinutes($tarifa->duracion);
    $item->save();

    return response()->json($item, 200);
  }

  private function create_full_date(string $fecha, string $hora){
    $parts = explode(':', $hora);
    $hora = (int) $parts[0];
    $minutos = (int) $parts[1];
    return Carbon::createFromDate($fecha)->hour($hora)->minute($minutos)->second(0);
  }

  private function get_cita(Request $request){
    return Cita::where('empleado_id', $request->empleado_id)
      ->whereDate('fecha', $request->fecha)
      ->where('hora', $request->hora)
      ->where('id', '!=', $request->id)
      ->get()
      ->first();
  }

}
