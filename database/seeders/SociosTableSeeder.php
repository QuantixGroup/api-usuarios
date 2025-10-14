<?php

namespace Database\Seeders;

use App\Models\Socio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SociosTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Socio::where('cedula', '11112222')->exists()) {
            Socio::create([
                'cedula' => '11112222',
                'nombre' => 'Juana',
                'apellido' => 'Pérez',
                'email' => 'juana@example.com',
                'contraseña' => '11112222',
                'telefono' => '0998765432',
                'direccion' => 'Av. Siempre Viva 456',
                'departamento' => 'Montevideo',
                'ciudad' => 'Montevideo',
                'ingreso_mensual' => 50000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1990-05-15',
                'estado' => 'pendiente'
            ]);
        }

        if (!Socio::where('cedula', '22223333')->exists()) {
            Socio::create([
                'cedula' => '22223333',
                'nombre' => 'Carlos',
                'apellido' => 'González',
                'email' => 'carlos@example.com',
                'contraseña' => '22223333',
                'telefono' => '0987654321',
                'direccion' => 'Calle Falsa 123',
                'departamento' => 'Canelones',
                'ciudad' => 'Las Piedras',
                'ingreso_mensual' => 45000,
                'situacion_laboral' => 'Independiente',
                'fecha_nacimiento' => '1985-03-20',
                'estado' => 'pendiente'
            ]);
        }

        if (!Socio::where('cedula', '33334444')->exists()) {
            Socio::create([
                'cedula' => '33334444',
                'nombre' => 'María',
                'apellido' => 'Rodríguez',
                'email' => 'maria@example.com',
                'contraseña' => '33334444',
                'telefono' => '0976543210',
                'direccion' => 'Bvar. Artigas 789',
                'departamento' => 'Montevideo',
                'ciudad' => 'Pocitos',
                'ingreso_mensual' => 60000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1992-11-08',
                'estado' => 'pendiente'
            ]);
        }

        if (!Socio::where('cedula', '44445555')->exists()) {
            Socio::create([
                'cedula' => '44445555',
                'nombre' => 'Luis',
                'apellido' => 'Martínez',
                'email' => 'luis@example.com',
                'contraseña' => '44445555',
                'telefono' => '0965432109',
                'direccion' => 'Av. Italia 321',
                'departamento' => 'Maldonado',
                'ciudad' => 'Punta del Este',
                'ingreso_mensual' => 55000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1975-07-12',
                'estado' => 'pendiente'
            ]);
        }

        if (!Socio::where('cedula', '55556666')->exists()) {
            Socio::create([
                'cedula' => '55556666',
                'nombre' => 'Ana',
                'apellido' => 'Silva',
                'email' => 'ana.silva@example.com',
                'contraseña' => '55556666',
                'telefono' => '0954321098',
                'direccion' => 'José Batlle y Ordóñez 567',
                'departamento' => 'Montevideo',
                'ciudad' => 'Carrasco',
                'ingreso_mensual' => 65000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1988-02-28',
                'estado' => 'pendiente'
            ]);
        }

        if (!Socio::where('cedula', '66667777')->exists()) {
            Socio::create([
                'cedula' => '66667777',
                'nombre' => 'Roberto',
                'apellido' => 'Fernández',
                'email' => 'roberto.fernandez@example.com',
                'contraseña' => '66667777',
                'telefono' => '0943210987',
                'direccion' => 'Dr. Luis Alberto de Herrera 890',
                'departamento' => 'Canelones',
                'ciudad' => 'Ciudad de la Costa',
                'ingreso_mensual' => 48000,
                'situacion_laboral' => 'Independiente',
                'fecha_nacimiento' => '1982-09-15',
                'estado' => 'pendiente'
            ]);
        }

        if (!Socio::where('cedula', '77778888')->exists()) {
            Socio::create([
                'cedula' => '77778888',
                'nombre' => 'Patricia',
                'apellido' => 'López',
                'email' => 'patricia.lopez@example.com',
                'contraseña' => '77778888',
                'telefono' => '0932109876',
                'direccion' => 'Av. Rivera 1234',
                'departamento' => 'Montevideo',
                'ciudad' => 'Buceo',
                'ingreso_mensual' => 72000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1995-12-03',
                'estado' => 'pendiente'
            ]);
        }
    }
}
