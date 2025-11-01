<?php

namespace Database\Seeders;

use App\Models\Socio;
use Illuminate\Database\Seeder;

class SociosTableSeeder extends Seeder
{
    public function run(): void
    {
        if (! Socio::where('cedula', '11112222')->exists()) {
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
                'estado_civil' => 'Soltera',
                'integrantes_familiares' => '2',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '22223333')->exists()) {
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
                'estado_civil' => 'Casado',
                'integrantes_familiares' => '4+',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '33334444')->exists()) {
            Socio::create([
                'cedula' => '33334444',
                'nombre' => 'María',
                'apellido' => 'Rodríguez',
                'email' => 'maria@example.com',
                'contraseña' => '33334444',
                'telefono' => '0976543210',
                'direccion' => 'Bvar. Artigas 789',
                'departamento' => 'Colonia',
                'ciudad' => 'Juan Lacaze',
                'ingreso_mensual' => 60000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1992-11-08',
                'estado_civil' => 'Divorciada',
                'integrantes_familiares' => '3',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '44445555')->exists()) {
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
                'estado_civil' => 'Casado',
                'integrantes_familiares' => '3',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '55556666')->exists()) {
            Socio::create([
                'cedula' => '55556666',
                'nombre' => 'Ana',
                'apellido' => 'Silva',
                'email' => 'ana.silva@example.com',
                'contraseña' => '55556666',
                'telefono' => '0954321098',
                'direccion' => 'José Batlle y Ordóñez 567',
                'departamento' => 'Salto',
                'ciudad' => 'Salto',
                'ingreso_mensual' => 65000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1988-02-28',
                'estado_civil' => 'Soltera',
                'integrantes_familiares' => '1',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '66667777')->exists()) {
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
                'estado_civil' => 'Viudo',
                'integrantes_familiares' => '2',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '77778888')->exists()) {
            Socio::create([
                'cedula' => '77778888',
                'nombre' => 'Patricia',
                'apellido' => 'López',
                'email' => 'patricia.lopez@example.com',
                'contraseña' => '77778888',
                'telefono' => '0932109876',
                'direccion' => 'Av. Rivera 1234',
                'departamento' => 'Montevideo',
                'ciudad' => 'Montevideo',
                'ingreso_mensual' => 42000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1995-12-03',
                'estado_civil' => 'Soltera',
                'integrantes_familiares' => '1',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '88889999')->exists()) {
            Socio::create([
                'cedula' => '88889999',
                'nombre' => 'Jorge',
                'apellido' => 'Gómez',
                'email' => 'jorge.gomez@example.com',
                'contraseña' => '88889999',
                'telefono' => '0921098765',
                'direccion' => 'Calle 8 de Octubre 2345',
                'departamento' => 'Montevideo',
                'ciudad' => 'Montevideo',
                'ingreso_mensual' => 70000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1978-06-25',
                'estado_civil' => 'Casado',
                'integrantes_familiares' => '4+',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }

        if (! Socio::where('cedula', '99990000')->exists()) {
            Socio::create([
                'cedula' => '99990000',
                'nombre' => 'Sofía',
                'apellido' => 'Díaz',
                'email' => 'sofia.diaz@example.com',
                'contraseña' => '99990000',
                'telefono' => '0912345678',
                'direccion' => 'Calle 9 de Julio 1234',
                'departamento' => 'Montevideo',
                'ciudad' => 'Montevideo',
                'ingreso_mensual' => 75000,
                'situacion_laboral' => 'Empleado/a',
                'fecha_nacimiento' => '1985-03-15',
                'estado_civil' => 'Divorciada',
                'integrantes_familiares' => '2',
                'estado' => 'pendiente',
                'motivacion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }
    }
}
