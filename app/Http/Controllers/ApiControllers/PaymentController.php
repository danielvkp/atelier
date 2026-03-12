<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function all(Request $request){
      $items = Payment::orderBy('created_at', 'DESC')
        ->whereDate('created_at', '>=', $request->desde)
        ->whereDate('created_at', '<=', $request->hasta)
        ->where('status', 'COMPLETADO')
        ->get();
      return response()->json($items, 200);
    }

    public function generate(Request $request){
      Excel::store(new PaymentExport($request->all()), "compras_{$request->desde}_{$request->hasta}.xls", 'excel');
      return [
        'url'      => asset("storage/excel/compras_{$request->desde}_{$request->hasta}.xls"),
        'filename' => "compras_{$request->desde}_{$request->hasta}.xls"
      ];
    }
}
