<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocioFactory extends Factory
{
    protected $model = Socio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cedula = $this->faker->unique()->numberBetween(10000000, 99999999);

        return [
            'cedula' => $cedula,
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '-18 years'),
            'telefono' => $this->faker->numerify('09#######'),
            'direccion' => $this->faker->streetAddress(),
            'departamento' => $this->faker->state(),
            'ciudad' => $this->faker->city(),
            'email' => $this->faker->unique()->safeEmail(),
            'foto_perfil' => null,
            'contraseña' => $cedula,
            'ingreso_mensual' => $this->faker->numberBetween(20000, 80000),
            'situacion_laboral' => $this->faker->randomElement(['Empleado/a', 'Desempleado/a', 'Independiente']),
            'estado_civil' => $this->faker->randomElement(['Soltero/a', 'Casado/a', 'Divorciado/a', 'Viudo/a']),
            'estado' => 'pendiente',
            'integrantes_familiares' => $this->faker->randomElement(['1', '2', '3', '4+']),
            'fecha_ingreso' => null,
            'fecha_egreso' => null,
            'motivacion' => $this->faker->sentence(10),
        ];
    }

    public function aprobado()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'aprobado',
                'fecha_ingreso' => now(),
            ];
        });
    }

    public function rechazado()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'rechazado',
            ];
        });
    }
}
