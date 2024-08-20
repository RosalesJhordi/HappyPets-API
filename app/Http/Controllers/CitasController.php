<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    //funcion para reservar citas
    public function store(Request $request){
        //Validar datos
        $validacion = Validator::make($request->all(),[
            'fecha' => 'required|date',
            'hora' => 'required',
            'nm_mascota' => 'required',
            'estado' => 'required',
            'observaciones' => 'required',
        ]);

        //si hay algun error al validar los datos
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Si los datos son validos, crear la nueva cita
        $cita = Citas::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'nm_mascota' => $request->nm_mascota,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
        ]);

        //Retornar la cita creada
        return response()->json(['cita' => $cita], 201);
    }
}
