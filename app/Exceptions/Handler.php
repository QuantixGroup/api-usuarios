<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {});
        $this->registerRenderables();
    }

    public function registerRenderables(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if (! $request->expectsJson() && ! $request->is('api/*')) {
                return null;
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'error' => true,
                    'message' => 'Errores de validación',
                    'errors' => $e->errors(),
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage() ?: 'No autenticado',
                ], 401);
            }

            $status = 500;
            if ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();
            }

            $payload = [
                'error' => true,
                'message' => $e->getMessage() ?: ($status === 500 ? 'Error del servidor' : 'Error'),
                'type' => get_class($e),
            ];

            if (config('app.debug') || app()->environment('local')) {
                $payload['file'] = $e->getFile();
                $payload['line'] = $e->getLine();
                $payload['trace'] = collect($e->getTrace())->map(function ($t) {
                    return Arr::except($t, ['args']);
                })->all();
            }

            return response()->json($payload, $status);
        });
    }
}
