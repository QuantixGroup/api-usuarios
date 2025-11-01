<?php

namespace Tests\Feature;

use App\Models\Socio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ApiPerfilTest extends TestCase
{
    use RefreshDatabase;

    public function test_perfil_requires_authentication()
    {
        $response = $this->getJson('/api/perfil');

        $response->assertStatus(401);
    }

    public function test_perfil_returns_authenticated_user()
    {
        $user = User::factory()->create();

        Socio::factory()->create(['cedula' => $user->cedula, 'email' => $user->email]);

        Passport::actingAs($user, ['*']);

        $response = $this->getJson('/api/perfil');

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => $user->email]);
    }
}
