<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Cita;
use App\Models\Producto;
use App\Models\Compra;
use App\Models\EnlacesPago;
use App\Models\ServicioTarifa;
use Carbon\Carbon;
use Ssheduardo\Redsys\Facades\Redsys;
use Exception;
use App\Mail\OrdenMail;
use App\Mail\PagoMail;
use App\Mail\ProductoMail;
use Mail;
use Log;

class RedsysController extends Controller
{
  public function checkout(Request $request){
    try {
          $config = config('redsys');

          $env = env('REDSYS_ENV');

          $orden = $this->createOrden($request);
          $monto = number_format($orden->precio, 2, '.', '');
          Redsys::setAmount($monto);
          Redsys::setOrder($orden->nro_orden);
          Redsys::setMerchantcode($config['merchantCode']);
          Redsys::setCurrency($config['currency']);
          Redsys::setTransactiontype($config['transactionType']);
          Redsys::setTerminal($config['terminal']);
          Redsys::setMethod('T');
          Redsys::setNotification(config('redsys.merchantUrl'));
          Redsys::setUrlOk(config('redsys.urlOk'));
          Redsys::setUrlKo(config('redsys.urlKo'));
          Redsys::setVersion('HMAC_SHA256_V1');
          Redsys::setTradeName($config['merchantName']);
          Redsys::setTitular($orden->nombre);
          Redsys::setProductDescription($orden->detalles);
          Redsys::setEnviroment($env);
          $signature = Redsys::generateMerchantSignature($config['environments'][$env]['secretKey']);
          Redsys::setMerchantSignature($signature);

          return Redsys::executeRedirection();
      } catch (Exception $e) {
          echo $e->getMessage();
      }
      return abort(500);
    return $request->all();
  }

  private function createOrden(Request $request){
    $detalles = null;
    $tarifa = null;
    $precio = 0;

    if($request->tipo_producto == 'cita'){
      $tarifa = ServicioTarifa::with('servicio')->find($request->tarifa);
      $detalles = "{$tarifa->servicio->nombre} {$tarifa->titulo} {$tarifa->duracion} / min";
      $precio = $tarifa->precio;
    }else if($request->tipo_producto == 'pdf'){
      $producto = Producto::find($request->producto_id);
      $detalles = "PDF: {$producto->nombre}";
      $precio = $producto->precio;
    }else{
      $producto = EnlacesPago::find($request->producto_id);
      $detalles = "Pago {$producto->titulo}";
      $precio = $producto->precio;
    }

    $payment = new Payment([
      'nro_orden' => date('is') . mt_rand(100, 999),
      'nombre'    => $request->nombre,
      'email'     => $request->email,
      'telefono'  => $request->telefono,
      'detalles'  => $detalles,
      'status'    => 'PENDIENTE',
      'precio'    => $precio,
      'tipo'      => 'cita'
    ]);

    $payment->save();

    if($request->tipo_producto == 'cita'){
      $payment->cita()->create([
        'duracion'  => $tarifa->duracion,
        'fecha'     => Carbon::createFromDate($request->full_date)->format('Y-m-d'),
        'hora'      => Carbon::createFromDate($request->full_date)->format('H:i'),
        'full_date' => Carbon::createFromDate($request->full_date),
        'end'       => Carbon::createFromDate($request->full_date)->addMinutes($tarifa->duracion),
        'status'    => env('REDSYS_ENV') == 'live' ? 'PENDIENTE' : 'COMPLETADO',
        'tipo'      => $tarifa->tipo,
        'servicio_tarifa_id' => $tarifa->id,
        'is_from_web' => true
      ]);
    }

    if($request->tipo_producto == 'pdf'){
      $payment->compra()->create([
        'producto_id'  => $request->producto_id,
      ]);
    }

    if($request->tipo_producto == 'otro'){
      $payment->compra()->create([
        'producto_id'  => $request->producto_id,
      ]);
    }

    return $payment;
  }

  public function pagook(){
    return view('redsys.pagook');
  }

  public function pagoko(){
    return view('redsys.pagoko');
  }

  public function notificacion(Request $request){
    Log::channel('redsys')->info(print_r('llego al hook', true));

    $config = config('redsys');
    $env = env('REDSYS_ENV');

    $version = $request["Ds_SignatureVersion"];
    $params = $request["Ds_MerchantParameters"];
    $signature = $request["Ds_Signature"];

    $parameters = Redsys::getMerchantParameters($request->input('Ds_MerchantParameters'));

    $DsResponse = $parameters["Ds_Response"];

    if (Redsys::check($config['environments'][$env]['secretKey'], $request->all()) && $DsResponse <= 99) {
        $this->sendNotification($parameters['Ds_Order']);
        Log::channel('redsys')->info(print_r('Pago aprobado', true));
    } else {
        Log::channel('redsys')->info(print_r($request->all(), true));
    }
   }

   private function sendNotification($nro_orden){
      $orden = Payment::where('nro_orden', $nro_orden)->get()->first();
      $orden->status = 'COMPLETADO';
      $orden->save();

      $cita = Cita::where('payment_id', $orden->id)->get()->first();

      if($cita){
        $cita->status = 'COMPLETADO';
        $cita->save();

        Mail::to($orden->email)->bcc(env('ADMIN_EMAIL'))
          ->send(new OrdenMail($orden));
      }

      $compra = Compra::where('payment_id', $orden->id)->get()->first();

      if($compra){
        $producto = Producto::find($compra->producto_id);

        if($producto){
          Mail::to($orden->email)->bcc(env('ADMIN_EMAIL'))
            ->send(new ProductoMail($producto->archivo, $orden, $producto->nombre));
        }

        $enlace = EnlacesPago::find($compra->producto_id);

        if($enlace){
          Mail::to($orden->email)->bcc(env('ADMIN_EMAIL'))
            ->send(new PagoMail($orden));
        }

      }

      return ['mensaje' => 'email enviado'];
    }

    public function test(){
      $io = date('is') . mt_rand(100, 999);

      return $io;

      $orden = Orden::get()->first();
      Mail::to($orden->email)
        ->bcc(env('ADMIN_EMAIL'))
        ->send(new OrdenMail($orden));

      return 'test';
    }
}
