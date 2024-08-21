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

    //funcion para mostrar todas las citas
    public function all(){
        $citas = Citas::all();
        return response()->json(['citas' => $citas], 200);
    }

    //funcion para obtener todas las Citas de un usuario
    public function citas(Request $request){
        $citas = Citas::where('id_cliente', $request->id_cliente)->get();
        return response()->json(['citas' => $citas], 200);
    }
}
