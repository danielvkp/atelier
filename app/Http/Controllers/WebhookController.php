<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Fuente;
use Log;

class WebhookController extends Controller
{
    public function lead(Request $request){
      //Log::info(print_r($request->all(), true));

      $large_string = $request['stripped-text'];

      if(str_contains($large_string, 'mudanzas24')){
          $datos = $this->datos_mudanzas_24($request['stripped-text']);
          $this->save_mudanzas_24($datos);
          Log::info(print_r($datos, true));
      }

      if(str_contains($large_string, 'Bambelo')){
          $datos = $this->datos_bambelo($request['stripped-text']);
          $this->save_bambelo($datos);
          Log::info(print_r($datos, true));
      }

      return $request->all();
    }

    private function save_mudanzas_24($datos){
      $fuente = Fuente::where('nombre', 'like', "%M24%")->get(['id'])->first();

      $cliente = Cliente::updateOrCreate([ 'email'  => $datos['correo_electronico']],
      [
          'nombre'       => $datos['nombre'],
          'telefono'     => $datos['telefono'],
          'email'        => $datos['correo_electronico'],
          'status'       => 'potencial',
          'seguimiento'  => 'Nuevo',
          'fuente_id'    => $fuente ? $fuente->id : NULL
      ]);

      $servicio = $cliente->servicio()->create([
        'detalles' => $this->makeDetalles24($datos),
        'status'   => 'pendiente',
      ]);

      $servicio->direccion()->create([
        'origen' => $this->makeDireccionOrigen($datos),
        'destino' => $this->makeDireccionFutura($datos)
      ]);

      $servicio->elevador()->create([
        'origen' => 'N/A',
        'destino' => 'N/A'
      ]);

    }

    private function save_bambelo($datos){
      $fuente = Fuente::where('nombre', 'like', "%BAM%")->get(['id'])->first();

      $cliente = Cliente::updateOrCreate([ 'email'  => $datos['e-mail']],
      [
          'nombre'       => $datos['nombre'],
          'telefono'     => $datos['telefono'],
          'email'        => $datos['e-mail'],
          'status'       => 'potencial',
          'seguimiento'  => 'Nuevo',
          'fuente_id'    => $fuente ? $fuente->id : NULL
      ]);

      $servicio = $cliente->servicio()->create([
        'detalles' => $this->makeDetalles($datos),
        'status'   => 'pendiente',
      ]);

      $servicio->direccion()->create([
        'origen' => $datos['domicilio'],
        'destino' => $this->makeDireccion($datos)
      ]);

      $servicio->elevador()->create([
        'origen' => 'N/A',
        'destino' => 'N/A'
      ]);
    }

    private function makeDireccionOrigen($datos){
      $direccion_futura = $datos['se_muda_de_direccion'] ?? NULL;
      $codigo_postal_futuro = $datos['se_muda_de_codigo_postal'] ?? NULL;
      $ciudad_futura = $datos['se_muda_de_ciudad'] ?? NULL;
      return "{$direccion_futura}, {$codigo_postal_futuro}, {$ciudad_futura}";
    }

    private function makeDireccionFutura($datos){
      $direccion_futura = $datos['se_muda_a_direccion'] ?? NULL;
      $codigo_postal_futuro = $datos['se_muda_a_lugar'] ?? NULL;
      $ciudad_futura = $datos['se_muda_a_ciudad'] ?? NULL;
      return "{$direccion_futura}, {$codigo_postal_futuro}, {$ciudad_futura}";
    }

    private function makeDireccion($datos){
      $direccion_futura = $datos['direccion_futura'] ?? NULL;
      $codigo_postal_futuro = $datos['codigo_postal_futuro'] ?? NULL;
      $ciudad_futura = $datos['ciudad_futura'] ?? NULL;
      $tipo_de_propiedad_futura = $datos['tipo_de_propiedad_futura'] ?? NULL;
      $codigo_postal_de_la_asignacion = $datos['codigo_postal_de_la_asignacion'] ?? NULL;
      return "{$direccion_futura}, {$codigo_postal_futuro}, {$ciudad_futura}";
    }

    private function makeDetalles($datos){
      $tipo_de_propiedad = $datos['tipo_de_propiedad'] ?? NULL;

      $fecha_de_la_solicitud = $datos['fecha_de_la_solicitud'] ?? NULL;

      $tipo = $datos['tipo'] ?? NULL;

      $destino = $datos['tipo_de_propiedad_futura'] ?? NULL;

      $deseada = $datos['fecha_deseada'] ?? NULL;

      $condiciones_de_empaquetamiento = $datos['condiciones_de_empaquetamiento'] ?? NULL;

      $requiere_desmontaje = $datos['requiere_(des)montaje'] ?? NULL;

      $comentarios = $datos['comentarios'] ?? NULL;

      $piso_actual = $datos['piso_actual'] ?? NULL;

      return "Tipo propiedad: {$tipo_de_propiedad} \n Piso actual: {$piso_actual} \n Fecha solicitud: {$fecha_de_la_solicitud} \n Fecha deseada: {$deseada} \n Tipo: {$tipo} \n Tipo destino: {$destino} \n Empaquetamiento: {$condiciones_de_empaquetamiento} \n Desmontaje: {$requiere_desmontaje} \n Comentarios: {$comentarios} \n";
    }

    private function makeDetalles24($datos){
      $fecha_prevista_para_la_mudanza = $datos['fecha_prevista_para_la_mudanza'] ?? NULL;

      $numero_de_habitaciones = $datos['numero_de_habitaciones'] ?? NULL;

      $tipo_propiedad_actual = $datos['se_muda_de_propiedad'] ?? NULL;

      $tipo_propiedad_futura = $datos['se_muda_a_propiedad'] ?? NULL;

      $asensor_actual = $datos['se_muda_de_hay_ascensor'] ?? NULL;

      $asensor_futuro = $datos['se_muda_a_hay_ascensor'] ?? NULL;

      $se_muda_a_tipo = $datos['se_muda_a_tipo'] ?? NULL;

      return "Fecha Prevista: {$fecha_prevista_para_la_mudanza} \n
       Habitaciones: {$numero_de_habitaciones} \n
       Propiedad actual: {$tipo_propiedad_actual} \n
       Asensor: {$asensor_actual} \n
       Propiedad futura: {$tipo_propiedad_futura} \n
       Asensor : {$asensor_futuro} \n
       Tipo: {$se_muda_a_tipo} \n";
    }

    public function datos_mudanzas_24($cadena_texto) {
        $datos = [];
        $lineas = explode("\n", $cadena_texto);
        $secciones = [];

        // Separar el texto en secciones lógicas
        $seccion_actual = 'general';
        foreach ($lineas as $linea) {
            if (strpos($linea, '*Se muda de:*') !== false) {
                $seccion_actual = 'se_muda_de';
            } else if (strpos($linea, '*Se muda a:*') !== false) {
                $seccion_actual = 'se_muda_a';
            }
            $secciones[$seccion_actual][] = $linea;
        }

        // Procesar cada sección
        foreach ($secciones as $nombre_seccion => $lineas_seccion) {
            foreach ($lineas_seccion as $linea) {
                $linea_limpia = trim($linea);
                $posicion_dos_puntos = strpos($linea_limpia, ':');

                if ($posicion_dos_puntos !== false && $posicion_dos_puntos < strlen($linea_limpia) - 1) {
                    $clave = trim(substr($linea_limpia, 0, $posicion_dos_puntos));
                    $valor = trim(substr($linea_limpia, $posicion_dos_puntos + 1));

                    // Limpiar el valor de información no deseada
                    $valor_limpio = preg_replace('/\s*Verificado\s*/i', '', $valor);

                    //$valor_limpio = preg_replace('/\s*\Encontrar el lugar en Google Maps.*\)/i', '', $valor_limpio);
                    $valor_limpio = preg_replace('/\(Encontrar el lugar en Google Maps/', '', $valor_limpio);

                    $valor_limpio = preg_replace('/<https?:\/\/.*>/i', '', $valor_limpio);
                    $valor_limpio = trim($valor_limpio);

                    // Formatear la clave
                    $clave_formateada = strtolower($clave);
                    $clave_formateada = preg_replace('/<https?:\/\/.*>/i', '', $clave_formateada);

                    $clave_formateada = str_replace(
                        ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
                        ['a', 'e', 'i', 'o', 'u', 'n'],
                        $clave_formateada
                    );
                    $clave_formateada = str_replace(' ', '_', $clave_formateada);

                    if (!empty($valor_limpio)) {
                        // Agregar el nombre de la sección a la clave
                        $clave_final = ($nombre_seccion !== 'general') ? $nombre_seccion . '_' . $clave_formateada : $clave_formateada;
                        $datos[$clave_final] = $valor_limpio;
                    }
                }
              }
          }
          return $datos;
      }

    public function datos_bambelo($cadena) {
          $datos = [];
          $lineas = explode("\n", $cadena);

          // Iterar sobre cada línea para encontrar pares clave-valor
          foreach ($lineas as $linea) {
              // Ignorar líneas vacías o de encabezado
              if (trim($linea) == '' || strpos($linea, '*') === 0) {
                  continue;
              }

              // Buscar el primer ':' para separar clave y valor
              $partes = explode(':', $linea, 2);

              if (count($partes) === 2) {
                  $clave = trim($partes[0]);
                  $valor = trim($partes[1]);

                  // Limpiar URLs y otros caracteres no deseados del valor
                  $valor_limpio = preg_replace('/<.*?>/', '', $valor);
                  $valor_limpio = trim($valor_limpio);

                  // Formatear la clave a minúsculas, sin acentos y con guiones bajos
                  $clave_formateada = strtolower($clave);
                  $clave_formateada = str_replace(
                      ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
                      ['a', 'e', 'i', 'o', 'u', 'n'],
                      $clave_formateada
                  );
                  $clave_formateada = str_replace(' ', '_', $clave_formateada);

                  // Agregar el par clave-valor al array de datos
                  if (!empty($valor_limpio)) {
                      $datos[$clave_formateada] = $valor_limpio;
                  }
              }
          }

          // Devolver el array con los datos extraídos
          return $datos;
      }

}
