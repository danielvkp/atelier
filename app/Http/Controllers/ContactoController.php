<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactoRequest;
use App\Mail\ContactoMail;
use App\Mail\TrabajaMail;
use App\Mail\CuestionarioMail;
use Mail;
use Log;

class ContactoController extends Controller
{
    public function contacto(){
      return view('contacto.contacto');
    }

    public function trabaja(){
      return view('contacto.trabaja');
    }

    public function enviarCV(Request $request){
      $data = $request->all();

      $rules = ['captcha' => 'required|captcha'];

      $validator = validator()->make($data, $rules);

      if ($validator->fails()) {
        return redirect()->back()->with([
          'message' => 'Captcha invalido'
        ])->withInput();
      }

      Mail::to(env('ADMIN_EMAIL'))
        ->bcc('danielvkp@live.com')
        ->send(new TrabajaMail($data));

      return redirect()->back()->with([
        'mensaje' => '!Email enviado con exito¡'
      ]);

      Log::channel('form_log')->info(print_r($data, true));

    }

    public function cuestionario(Request $request){
      $data = $request->all();


      Mail::to(env('ADMIN_EMAIL'))
        ->bcc('danielvkp@live.com')
        ->send(new CuestionarioMail($data));

      return redirect()->back()->with([
        'mensaje' => '!Email enviado con exito¡'
      ]);

      Log::channel('form_log')->info(print_r($data, true));
    }

    public function enviarContacto(ContactoRequest $request){
      $data = $request->all();

      Log::channel('contacto_log')->info(print_r($data, true));

      $rules = ['captcha' => 'required|captcha'];

      $validator = validator()->make($data, $rules);

      if ($validator->fails()) {
        return redirect()->back()->with([
          'message' => 'Captcha invalido'
        ])->withInput();
      }

      Mail::to(env('ADMIN_EMAIL'))
        ->bcc('danielvkp@live.com')
        ->send(new ContactoMail($data));

      return redirect()->back()->with([
        'mensaje' => '!Email enviado con exito¡'
      ]);
    }

    public function enviarContactoPlan(ContactoRequest $request){

    }

    public function send(Request $request){

    }
}
