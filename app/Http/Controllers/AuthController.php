<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $datos = $request->validate([
            'cedula' => ['required', 'string'], 
            'contrasena' => ['required', 'string'],
        ]);

        $respuesta = Http::asForm()->post(url('/oauth/token'), [
            'grant_type' => 'password',
            'client_id' => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'username' => $datos['cedula'],     
            'password' => $datos['contrasena'], 
           
        ]);

        if (!$respuesta->ok()) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return $respuesta->json(); 
    }

    public function logout(Request $request)
    {
        $usuario = $request->user();
        $usuario->token()->revoke(); 
        return response()->json(['message' => 'Sesión cerrada']);
    }

}
