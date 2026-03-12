<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitaRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
          'fecha'       => 'required',
          'hora'        => 'required',
          'nombre'      => 'required',
          'email'       => 'required',
          'telefono'    => 'required',
          'empleado_id' => 'required',
          'servicio_tarifa_id' => 'required',
        ];
    }

    public function messages(): array {
      return [
        'nombre.required'   => 'Campo es necesario.',
        'email.required'    => 'Campo es necesario.',
        'telefono.required' => 'Campo es necesario.',
        'fecha.required'    => 'Campo es necesario.',
        'hora.required'     => 'Campo es necesario.',
        'empleado_id.required'        => 'Campo es necesario.',
        'servicio_tarifa_id.required' => 'Campo es necesario.',
      ];
    }
}
