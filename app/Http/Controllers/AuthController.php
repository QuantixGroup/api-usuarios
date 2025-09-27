<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Socio;
use Illuminate\Http\Request as HttpRequest;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(HttpRequest $request)
    {
        $data = $request->validate([
            'cedula' => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ]);

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($client) {
            $clientId = $client->id;
            $clientSecret = $client->secret;
        } else {
            $clientId = config('services.passport.password_client_id');
            $clientSecret = config('services.passport.password_client_secret');
        }

        $socio = Socio::where('cedula', $data['cedula'])->first();
        if (!$socio || $socio->estado !== 'aprobado') {
            return response()->json(['error' => 'Usuario no aprobado'], 403);
        }

        $params = [
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $data['cedula'],
            'password' => $data['contrasena'],
            'scope' => '*',
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
