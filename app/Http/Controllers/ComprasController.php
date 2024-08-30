<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComprasController extends Controller
{
    //funcion para realizar una compra
    public function store(Request $request){
        $validacion = Validator::make($request->all(),[
            'id_cliente' => 'required',
            'id_producto' => 'required',
            'cantidad' => 'required',
        ]);

        //si hay algun error al validar los datos
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Si los datos son validos, realizar la compra
        $compra = Compras::create([
            'id_cliente' => $request->id_cliente,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
        ]);

        return response()->json([
            'mensaje' => 'Compra realizada'
        ]);
    }

    //funcion para mostar las compras de un cliente
    public function compra(Request $request){
        $compra = Compras::where('id_cliente',$request->id_cliente)->get();

        return response()->json([
            'compras' => $compra,
        ]);
    }

    //funcion para caneclar compra

    public function delcompra(Request $request){
        $compra = Compras::find($request->id_compra);
        if($compra){
            $compra->delete();
            return response()->json([
               'mensaje' => 'Compra cancelada'
            ]);
        }
        return response()->json([
           'error' => 'Compra no encontrada'
        ], 404);
    }
}
