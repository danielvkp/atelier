<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ServicioTarifa;
use App\Models\Servicio;
use App\Models\Orden;
use App\Models\Cita;
use Illuminate\Support\Facades\DB;

class CalendarioController extends Controller
{
    public function calendario(Request $request, $tarifa = null){
      $tipo = $request->filled('tipo') ? $request->tipo : null;

      $item = ServicioTarifa::where('id', $tarifa)
        ->get(['id', 'servicio_id'])
        ->first();

      return view('calendario.calendario', compact('item', 'tipo'));
    }

    public function getTarifas(){
      $items = Servicio::whereHas('tarifa')
        ->with('tarifa')
        ->get();
      return response()->json($items, 200);
    }

    private function getCurrentOffset(string $fecha_selecionada){
      $current_day = Carbon::now('Europe/Madrid');

      $fecha_del_calendario =  Carbon::createFromDate($fecha_selecionada);

      $is_same_day = $current_day->isSameDay($fecha_del_calendario);

      if($is_same_day){
        $current_hour = Carbon::now('Europe/Madrid')->format('H');

        $current_full_date = Carbon::now('Europe/Madrid')->setTimeFromTimeString("{$current_hour}:00:00");

        $hora_final = $current_full_date->copy()->add('minutes', 240);

        $hora_inicio = Carbon::createFromDate("{$fecha_selecionada} 09:00");

        $horas_a_remover = $this->generarTramos($hora_inicio, $hora_final);

        return $horas_a_remover;
      }
      return [];
    }

    public function getHorario(string $fecha_selecionada, int $tarifa_id){
      $offset_h = $this->getCurrentOffset($fecha_selecionada);

      $tarifa = ServicioTarifa::find($tarifa_id);

      $minutos = (int) $tarifa->duracion;

      $arreglo_limites_medio_dia = $this->getLimites($fecha_selecionada, $minutos, $tarifa->tipo);

      $hora_inicio = $this->makeHora($fecha_selecionada, $tarifa->tipo)[0];

      $hora_final = $this->makeHora($fecha_selecionada, $tarifa->tipo)[1];

      $horarios_sin_restar = $this->generarTramos($hora_inicio, $hora_final);

      $horas_ocupadas_default = $tarifa->tipo == 'Senior' ? [] : $this->horasOcupadas($fecha_selecionada);

      $merged = collect($horas_ocupadas_default)->merge($arreglo_limites_medio_dia);

      $horario_casi_final = collect($horarios_sin_restar)->diff($merged);

      $horas_ocupadas_reservas = $this->getReservas($fecha_selecionada, $tarifa->tipo);

      $horario_final = collect($horario_casi_final)
        ->diff($horas_ocupadas_reservas)
        ->diff($offset_h);

      $numero_dia = Carbon::createFromDate("{$fecha_selecionada}")->dayOfWeek;

      if($tarifa->tipo == 'Senior' && $numero_dia == 5){
        $horario_final = collect([]);
      }

      return response()->json($horario_final->all(), 200);

    }

    private function getReservas(string $fecha_selecionada, string $tipo_tarifa){
        $horas_senior = [];

        if($tipo_tarifa == 'Senior'){

          $orden_senior = Cita::where('tipo', 'Senior')
            ->whereDate('full_date', $fecha_selecionada)
            ->where('status', 'COMPLETADO')
            ->get(['full_date']);

          $horas_senior = collect($orden_senior)->map(function ($item, $key) {
            return Carbon::createFromDate($item['full_date']);
          });

          return $horas_senior;

        }

        if($tipo_tarifa == 'Semisenior'){

          $orden_semisenior = Cita::where('tipo', 'Semisenior')
            ->whereDate('full_date', $fecha_selecionada)
            ->where('status', 'COMPLETADO')
            ->get(['full_date']);

          $horas_semisenior = collect($orden_semisenior)->map(function ($item, $key) {
            return Carbon::createFromDate($item['full_date']);
          });

          return $horas_semisenior;

        }

      if($tipo_tarifa == 'Junior'){
          $hora_quiebre = Carbon::createFromDate("{$fecha_selecionada} 14:00:00");

          $orden_junior = DB::table('cita')
              ->select('full_date')
              ->selectRaw('count(*) as total_count')
              ->whereDate('fecha', $fecha_selecionada)
              ->where('tipo', 'Junior')
              ->groupBy('full_date')
              ->get();

          $horas_junior = collect($orden_junior)->filter(function ($item, $key) use ($hora_quiebre)  {
              $hora_carbon = Carbon::createFromDate($item->full_date);

              $numero_dia = $hora_carbon->dayOfWeek;
              //dd($numero_dia);
              if($hora_carbon->greaterThanOrEqualTo($hora_quiebre) && $item->total_count > 1 && $numero_dia == 2){
                 return true;
              }

              if($hora_carbon->lessThanOrEqualTo($hora_quiebre) && $item->total_count > 2){
                return true;
              }

              if($hora_carbon->greaterThanOrEqualTo($hora_quiebre) && $item->total_count > 0 && $numero_dia != 2){

                return true;
              }

              return false;
          })
          ->map(function ($item, $key) {
             return Carbon::createFromDate($item->full_date);
          });

          return $horas_junior;

        }

        return [];
    }

    private function makeHora(string $fecha_selecionada, string $tipo_tarifa){
     if($tipo_tarifa == 'Senior'){
        return [
          Carbon::createFromDate("{$fecha_selecionada} 09:00"),
          Carbon::createFromDate("{$fecha_selecionada} 20:00")
        ];
      }
      return [
         Carbon::createFromDate("{$fecha_selecionada} 09:00"),
         Carbon::createFromDate("{$fecha_selecionada} 19:00")
      ];

    }

    private function getLimites($fecha_selecionada, $minutos, string $tipo_tarifa){
      /*Remover minutos del medio dia*/
      $final_medio_dia = Carbon::createFromDate("{$fecha_selecionada} 15:00");
      $inicio_medio_dia = $final_medio_dia->copy()->subMinutes(60);

      /*Arreglos */
      $medio_dia = $this->generarTramos($inicio_medio_dia, $final_medio_dia);

      if($tipo_tarifa == 'Senior'){
        return [];
      }

      return collect($medio_dia);
    }

    private function horasOcupadas($fecha_selecionada){
      $hora_inicio = Carbon::createFromDate("{$fecha_selecionada} 14:00");

      $hora_final = Carbon::createFromDate("{$fecha_selecionada} 15:00");

      return $this->generarTramos($hora_inicio, $hora_final);
    }

    private function generarTramos($hora_inicio, $hora_final){
      $diferencia = $hora_inicio->diffInMinutes($hora_final->shiftTimezone('UTC'));

      $intervalos = round($diferencia / 60);

      $collection = collect()->range(0, $intervalos);

      $horarios = $collection->map(function (int $item, int $key) use ($hora_inicio) {
        return $hora_inicio->copy()->addMinutes(60 * $item);
      });

      return $horarios;

    }

}
