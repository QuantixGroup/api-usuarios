<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;




class UserController extends Controller
{
    public function verMiPerfil(Request $request)
    {
        $personaUsuaria = $request->user();

        return response()->json([
            'identificador' => $personaUsuaria->id,
            'cedula'        => $personaUsuaria->cedula,
            'nombre'        => $personaUsuaria->name ?? $personaUsuaria->nombre ?? null,
            'email'         => $personaUsuaria->email,
            'telefono'      => $personaUsuaria->telefono ?? null,
            'direccion'     => $personaUsuaria->direccion ?? null,
        ]);
    }

    public function actualizarMiPerfil(Request $request)
    {
        $personaUsuaria = $request->user();

        $datos = $request->validate([
            'nombre'    => ['sometimes','string','max:100'],
            'telefono'  => ['sometimes','string','max:50'],
            'direccion' => ['sometimes','string','max:255'],
            'email'     => ['sometimes','email','max:255','unique:users,email,'.$personaUsuaria->id],
        ]);

        if (isset($datos['nombre'])) {
            $datos['name'] = $datos['nombre'];
            unset($datos['nombre']);
        }

        $personaUsuaria->fill($datos)->save();

        return response()->json(['message' => 'Perfil actualizado']);
    }

    public function cambiarMiContrasena(Request $request)
    {
        $personaUsuaria = $request->user();

        $datos = $request->validate([
            'contrasena_actual'             => ['required','string'],
            'contrasena_nueva'              => ['required','string','min:8','confirmed'],
        ]);

        if (! Hash::check($datos['contrasena_actual'], $personaUsuaria->password)) {
            return response()->json(['error' => 'La contraseña actual no coincide'], 422);
        }

        $personaUsuaria->password = Hash::make($datos['contrasena_nueva']);
        $personaUsuaria->save();

        return response()->json(['message' => 'Contraseña actualizada']);
    }

    public function eliminarMiCuenta(Request $request)
    {
        $personaUsuaria = $request->user();

        foreach ($personaUsuaria->tokens as $token) {
            $token->revoke();
        }

        $personaUsuaria->delete();

        return response()->json(['message' => 'Cuenta desactivada']);
    }

    public function ValidateToken(Request $request)
    {
        $user = auth('api')->user();

        return response()->json([
            'nombre' => $user->name,
            'rol' => $user->rol
        ]);
    }


    public function Logout(Request $request)
    {
        $request->user()->token()->revoke();
        return ['message' => 'Token Revoked'];


    }


}
