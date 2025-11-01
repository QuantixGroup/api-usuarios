<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(HttpRequest $request)
    {
        $data = $request->validate([
            'cedula' => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ]);

        $socio = Socio::where('cedula', $data['cedula'])->first();
        if (! $socio || $socio->estado !== 'aprobado') {
            return response()->json(['error' => 'Usuario no aprobado'], 403);
        }

        $usuario = User::where('cedula', $socio->cedula)->first();

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->where('revoked', false)
            ->first();

        if ($client) {
            $clientId = $client->id;
            $clientSecret = $client->secret;
        }

        if (empty($clientId)) {
            $clientId = config('services.passport.password_client_id');
            $clientSecret = config('services.passport.password_client_secret');
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

        try {
            $res = app()->handle($sub);
            $responseData = json_decode($res->getContent(), true);
        } catch (\Throwable $e) {
            Log::error('Error al solicitar /oauth/token: '.$e->getMessage(), ['exception' => $e]);

            return response()->json([
                'error' => true,
                'message' => 'Error al emitir token de acceso',
            ], 500);
        }

        if ($res->getStatusCode() === 200 && isset($responseData['access_token'])) {
            $primerInicio = $usuario ? $usuario->primer_inicio : true;
            $responseData['primer_inicio'] = $primerInicio;
        }

        return response()->json($responseData, $res->getStatusCode())
            ->withHeaders($res->headers->all());
    }

    public function logout(Request $request)
    {
        $usuario = $request->user();
        $usuario->token()->revoke();

        return response()->json(['message' => 'Sesión cerrada']);
    }
}
