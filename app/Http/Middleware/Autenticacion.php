<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http as HttpClient;

class Autenticacion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');
        if ($authorization === null) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $base = config('app.api_auth_url') ?? env('API_AUTH_URL');
        $validateUrl = $base ? rtrim($base, '/') . '/api/validate' : url('/api/validate');

        try {
            $validacion = HttpClient::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->get($validateUrl);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Auth service unreachable'], 503);
        }

        if ($validacion->status() !== 200) {
            return response()->json(['error' => 'Invalid Token'], 401);
        }

        $request->attributes->set('user', $validacion->json());

        return $next($request);
    }
}
