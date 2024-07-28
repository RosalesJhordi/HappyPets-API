<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Funcion para registrar usuarios
    public function registrar(Request $request){

        //Validacion de datos

        $validacion = Validator::makeValidacion($request,[
            'dni'       => 'required|min:8|max:8|unique:users,dni',
            'telefono'  => 'required|unique:users,telefono',
            'rol'       => 'required',
            'password'  => 'required|min:6|confirmed',
        ]);

        //Si hay algun error al validar
        
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Crear nuevo usuario si no hay errores

        $usuario = User::create([
            'dni'       => $request->dni,
            'telefono'  => $request->telefono,
            'rol'       => $request->rol,
            'password'  => Hash::make($request->password),
        ]);

        //Crear token PAT para el usuario

        $accessTKN = $usuario->createTokenn('token')->plainTextToken;

        //Obtener token

        $user = User::where('dni',$request->dni)->first();

        $token = User::find($user->id)->tokens()->where('name','token')->pluck('token')->first();

        //Retornar respuesta json

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }


    //Funcion para autenticaar usuarios

    public function autenticar(Request $request){
        //Validacion de datos

        $validacion = Validator::make($request->all(),[
            'dni'       => 'required|min:8|max:8',
            'password'  => 'required|min:6',
        ]);

        //Si hay algun error al validar
        
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }

        //Autenticar usuario

        if (!auth()->attempt($request->only('dni', 'password'), $request->has('remember'))) {
            return response()->json(['mensaje' => 'Credenciales Incorrectas']);
        }

        // Buscar usuario y obtener el token PAT
        $user = User::where('email', $request->email)->first();
        $userId = $user->id;
        $token = User::find($userId)->tokens()->where('name', 'auth_token')->pluck('token')->first();

        //Retornar los datos de usuario y el token de acceso
        return response()->json([
            'user' => $user,
            "token" => $token
        ], 201);
    }
}
