<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductosController extends Controller
{
    //funcion para agregar Productos

    public function store(Request $request){
        //Validar datos
        $validacion = Validator::make($request->all(),[
            'nmproducto' => 'required|unique:productos,nmproducto',
            'descripcion' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'imagen' => 'required',
        ]);

        //si hay algun error al validar los datos
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Almacenar imagen
        $imagen = $request->file('imagen');
        $nombreImagen = Str::uuid().'.'.$imagen->getClientOriginalExtension();
        $path = public_path('ServidorProductos');
        $imagen->move($path, $nombreImagen);

        //Si los datos son validos, crear el nuevo servicio
        $servicio = Productos::create([
            'nmproducto' => $request->nmproducto,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'imagen' => $nombreImagen,
        ]);

        return response()->json(['servicio' => $servicio], 201);
    }

    //funcion para mostrar todos los servicios
    public function all(){
        $productos = Productos::all();
        return response()->json(['productos' => $productos], 200);
    }

}
