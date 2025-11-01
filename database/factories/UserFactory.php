<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $cedula = (string) $this->faker->unique()->numberBetween(10000000, 99999999);

        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'cedula' => $cedula,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'primer_inicio' => true,
        ];
    }
}
