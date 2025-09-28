<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request as HttpRequest;

use Illuminate\Http\Request;

class AuthController extends Controller
{
     public function login(Request $request)
{
    $data = $request->validate([
        'cedula'     => ['required','string'],
        'contrasena' => ['required','string'],
    ]);

    $params = [
        'grant_type'    => 'password',
        'client_id'     => 2,
        'client_secret' => 'ERmJxTnr1upAMCP582crunhkrhPCEEZafQXyM43z',
        'username'      => $data['cedula'],
        'password'      => $data['contrasena'],
    ];

    $response = Http::asForm()
        ->post(url('/oauth/token'), $params);

    if ($response->failed()) {
        return response()->json(['error' => 'Credenciales inválidas'], 401);
    }

    return $response->json();
}


    public function logout(Request $request)
    {
        $usuario = $request->user();
        $usuario->token()->revoke(); 
        return response()->json(['message' => 'Sesión cerrada']);
    }

}
