<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request as HttpRequest;

use Illuminate\Http\Request;

class AuthController extends Controller
{
     public function login(HttpRequest $request)
    {
        $data = $request->validate([
            'cedula'     => ['required','string'],
            'contrasena' => ['required','string'],
        ]);

        $params = [
            'grant_type'    => 'password',
            'client_id'     => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'username'      => $data['cedula'],
            'password'      => $data['contrasena'],
            'scope'         => '*',
        ];

        $sub = HttpRequest::create('/oauth/token', 'POST', $params, [], [], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        $res = app()->handle($sub);

        return response($res->getContent(), $res->getStatusCode())
            ->withHeaders($res->headers->all());
    }

    public function logout(Request $request)
    {
        $usuario = $request->user();
        $usuario->token()->revoke(); 
        return response()->json(['message' => 'Sesión cerrada']);
    }

}
