<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legal;

class LegalController extends Controller
{
    public function politica_cookies(){
      $legal = Legal::get()->last();
      return view('legal.cookies', compact('legal'));
    }

    public function privacidad(){
      $legal = Legal::get()->last();
      return view('legal.privacidad', compact('legal'));
    }

    public function condiciones(){
      $legal = Legal::get()->last();
      return view('legal.legal', compact('legal'));
    }
}
