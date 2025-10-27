<?php

namespace App\Http\Controllers;

use App\Models\User;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function verMiPerfil(Request $request)
    {
        $personaUsuaria = $request->user();
        $socio = \App\Models\Socio::where('cedula', $personaUsuaria->cedula)->first();

        if (!$socio) {
            return response()->json(['error' => 'Socio no encontrado'], 404);
        }

        return response()->json([
            'identificador' => $socio->id ?? null,
            'cedula' => $socio->cedula ?? null,
            'nombre' => $socio->nombre ?? null,
            'apellido' => $socio->apellido ?? null,
            'fecha_nacimiento' => $socio->fecha_nacimiento ?? null,
            'telefono' => $socio->telefono ?? null,
            'direccion' => $socio->direccion ?? null,
            'departamento' => $socio->departamento ?? null,
            'ciudad' => $socio->ciudad ?? null,
            'email' => $socio->email ?? null,
            'ingresos_mensuales' => $socio->ingreso_mensual ?? null,
            'situacion_laboral' => $socio->situacion_laboral ?? null,
            'estado_civil' => $socio->estado_civil ?? null,
            'cantidad_integrantes' => $socio->integrantes_familiares ?? null,
            'foto_perfil' => $socio->foto_perfil ? url(Storage::url($socio->foto_perfil)) : null,
        ]);
    }

    public function actualizarMiPerfil(Request $request)
    {
        $personaUsuaria = $request->user();

        $datos = $request->validate([
            'nombre' => ['sometimes', 'string', 'max:100'],
            'telefono' => ['sometimes', 'string', 'max:50'],
            'direccion' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $personaUsuaria->id],
        ]);

        if (isset($datos['nombre'])) {
            $datos['name'] = $datos['nombre'];
            unset($datos['nombre']);
        }

        try {
            DB::beginTransaction();

            $personaUsuaria->fill($datos)->save();

            $socio = \App\Models\Socio::where('cedula', $personaUsuaria->cedula)->first();
            if ($socio) {
                $socioChanged = false;

                if ($request->has('ingresos_mensuales')) {
                    $socio->ingreso_mensual = $request->post('ingresos_mensuales');
                    $socioChanged = true;
                }

                if ($request->has('situacion_laboral')) {
                    $socio->situacion_laboral = $request->post('situacion_laboral');
                    $socioChanged = true;
                }

                if ($request->has('cantidad_integrantes')) {
                    $socio->integrantes_familiares = $request->post('cantidad_integrantes');
                    $socioChanged = true;
                }

                if ($request->has('estado_civil')) {
                    $socio->estado_civil = $request->post('estado_civil');
                    $socioChanged = true;
                }

                if ($socioChanged) {
                    $socio->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error actualizando perfil de usuario ' . ($personaUsuaria->id ?? 'n/a') . ': ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Ocurrió un error al actualizar el perfil'], 500);
        }

        return response()->json(['message' => 'Perfil actualizado']);
    }

    public function cambiarMiContrasena(Request $request)
    {
        $personaUsuaria = $request->user();

        $datos = $request->validate([
            'contrasena_actual' => ['required', 'string'],
            'contrasena_nueva' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($datos['contrasena_actual'], $personaUsuaria->password)) {
            return response()->json(['error' => 'La contraseña actual no coincide'], 422);
        }

        $personaUsuaria->password = Hash::make($datos['contrasena_nueva']);
        $personaUsuaria->primer_inicio = false;
        $personaUsuaria->save();

        return response()->json(['message' => 'Contraseña actualizada']);
    }

    public function ValidateToken(Request $request)
    {
        $user = auth('api')->user();

        return response()->json([
            'cedula' => $user->cedula,
            'nombre' => $user->name,
            'rol' => $user->rol
        ]);
    }

    public function Logout(Request $request)
    {
        $request->user()->token()->revoke();
        return ['message' => 'Token Revoked'];
    }

    public function fotoPerfil(Request $request)
    {
        $personaUsuaria = $request->user();

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'El archivo debe ser una imagen válida (JPG, PNG, GIF) de máximo 2MB',
                'errors' => $validator->errors()
            ], 422);
        }

        if (request()->hasFile('foto')) {
            $file = request()->file('foto');

            DB::beginTransaction();
            try {
                $path = $file->store('fotos_perfil', 'public');

                $socio = \App\Models\Socio::where('cedula', $personaUsuaria->cedula)->first();
                if (!$socio) {
                    return response()->json(['error' => 'Socio no encontrado'], 404);
                }

                if ($socio->foto_perfil && Storage::disk('public')->exists($socio->foto_perfil)) {
                    Storage::disk('public')->delete($socio->foto_perfil);
                }

                $socio->foto_perfil = $path;
                $socio->save();

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Foto de perfil actualizada correctamente',
                    'url_foto' => url(Storage::url($path))
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error al subir foto de perfil: ' . $e->getMessage(), ['exception' => $e]);

                if (isset($path) && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                return response()->json(['error' => 'Error al subir foto'], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se ha subido ninguna foto'
            ], 400);
        }
    }

}
