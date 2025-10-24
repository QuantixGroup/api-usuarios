<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate([
            'cedula' => '87654321'
        ], [
            'name' => 'Laura',
            'apellido' => 'Gomez',
            'telefono' => '090123123',
            'fecha_nacimiento' => '1991-10-15',
            'fecha_ingreso' => now(),
            'email' => 'laura.administracion@covimt17.org',
            'password' => Hash::make('87654321'),
            'primer_password' => true,
        ]);
    }
}
