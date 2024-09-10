<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    //Funcion para registrar usuarios
    public function registrar(Request $request){

        //Validacion de datos

        $validacion = Validator::make($request->all(),[
            'dni'       => 'required|min:8|max:8|unique:users,dni',
            'telefono'  => 'required|unique:users,telefono',
            'password'  => 'required|min:6|confirmed',
        ]);

        //Si hay algun error al validar
        
        if($validacion->fails()){
            return response()->json(['error' => $validacion->errors()], 400);
        }
        //Crear nuevo usuario si no hay errores
        $permisos = [];
        if($request->dni == "71654843"){
            $permisos = ['Administrador'];
        }else{
            $permisos = ['Usuario'];
        }
        $usuario = User::create([
            'dni'       => $request->dni,
            'telefono'  => $request->telefono,
            'password'  => Hash::make($request->password),
            'permisos'  => implode(',', $permisos)
        ]);

        //Crear token PAT para el usuario

        $accessTKN = $usuario->createToken('token')->plainTextToken;

        //Obtener token

        $user = User::where('dni',$request->dni)->first();

        $token = $usuario->tokens()->where('name', 'token')->pluck('token')->first();

        //Retornar respuesta json

        return response()->json([
            'mensaje' => 'Registro exitoso',
            'token' => $token
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
            return response()->json(['error' => 'Credenciales Incorrectas']);
        }

        // Buscar usuario y obtener el token PAT
        $user = User::where('dni', $request->dni)->first();
        $userId = $user->id;
        $token = User::find($userId)->tokens()->where('name', 'token')->pluck('token')->first();

        //Retornar los datos de usuario y el token de acceso
        return response()->json([
            'mensaje' => 'Autenticado',
            'token' => $token
        ], 201);
    }

    //funcion para obtener datos de usuarios con token 
    public function datos(Request $request){
        $token = $request->bearerToken();

        //$pat = PersonalAccessToken::findToken($token);
        $pat = PersonalAccessToken::where('token', $token)->first();
        if ($pat) {
            $user = $pat->tokenable;
            return response()->json([
                'user' => $user
            ]);
        } else {
            return response()->json([
                "error" => "Token PAT invalido"
            ], 401);
        }
    }
    //shf
}
