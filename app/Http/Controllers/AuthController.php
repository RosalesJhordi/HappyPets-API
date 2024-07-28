<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Funcion para registrar usuarios
    public function registrar(Request $request){
        $validacion = Validator::makeValidacion($request,[
            
        ]);
    }
}
