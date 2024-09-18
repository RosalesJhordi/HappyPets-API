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
            'precio' => 'required',
            'categoria' => 'required',
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
            'precio' => $request->precio,
            'categoria' => $request->categoria,
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
    //funcion para filtrar por categoria
    public function filtro(Request $request){
        $servicios = Servicios::where('categoria', $request->categoria)->get();
        return response()->json(['servicios' => $servicios], 200);
    }

    //funcion para mostrar un solo servicio por id
    public function show($id){
        $servicio = Servicios::find($id);

        if($servicio){
            return response()->json(['servicio' => $servicio], 200);
        } else {
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }
    }
}
