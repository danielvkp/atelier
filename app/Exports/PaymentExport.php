<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class PaymentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request){
       $this->request = $request;
    }

    public function collection(){
      return Payment::orderBy('created_at', 'DESC')
        ->whereDate('created_at', '>=', $this->request['desde'])
        ->whereDate('created_at', '<=', $this->request['hasta'])
        ->where('status', 'COMPLETADO')
        ->get();
    }

    public function headings(): array {
       return [
           'Nro Orden',
           'Nombre',
           'Email',
           'Telefono',
           'Detalles',
           'Fecha',
       ];
   }


    public function map($payment): array{
        return [
            $payment->nro_orden,
            $payment->nombre,
            $payment->email,
            $payment->telefono,
            $payment->detalles,
            Carbon::parse($payment->created_at)->format('d-m-Y'),
        ];
    }
}
