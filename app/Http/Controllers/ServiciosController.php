<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Testing\Constraints\CountInDatabase;

class ServiciosController extends Controller
{
    //funcion para agregar servicios

    public function store(Request $request){
        //Validar datos
        $validacion = Validator::make($request->all(),[
            'nm_servicio' => 'required|unique:servicios,nm_servicio',
            'duracion_aprox' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        //si hay algun error al validar los datos
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Almacenar imagen
        $imagen = $request->file('imagen');
        $nombreImagen = Str::uuid().'.'.$imagen->getClientOriginalExtension();
        $path = public_path('ServidorServicios');
        $imagen->move($path, $nombreImagen);

        //Si los datos son validos, crear el nuevo servicio
        $servicio = Servicios::create([
            'nm_servicio' => $request->nm_servicio,
            'duracion_aprox' => $request->duracion_aprox,
            'descripcion' => $request->descripcion,
            'imagen' => $nombreImagen,
        ]);

        return response()->json(['servicio' => $servicio], 201);
    }

    //funcion para mostrar todos los servicios
    public function all(){
        $servicios = Servicios::all();
        return response()->json(['servicios' => $servicios], 200);
    }

    //funcion para editar
    //funcion para eliminar
}
