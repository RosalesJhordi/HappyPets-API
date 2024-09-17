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
            'fecha' => 'required',
            'hora' => 'required',
            'nm_mascota' => 'required',
        ]);

        //si hay algun error al validar los datos
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Si los datos son validos, crear la nueva cita
        $cita = Citas::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'id_cliente' => $request->id_cliente,
            'id_servicio' => $request->id_servicio,
            'nm_mascota' => $request->nm_mascota,
        ]);
        
        //Retornar la cita creada
        return response()->json([
            'message' => 'Cita reservada correctamente',
        ],200);
    }

    //funcion para eliminar citas
    public function eliminar(Request $request){

        //elimiar cita
        $cita = Citas::find($request->id_cita);
        $cita->delete();

        return response()->json([
           'message' => 'Cita cancelada correctamente'
        ]);
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
