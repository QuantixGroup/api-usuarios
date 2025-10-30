<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Socio;

class SociosApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_socio_public_endpoint()
    {
        $payload = Socio::factory()->make()->toArray();

        $response = $this->postJson('/api/socios', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('socios', [
            'cedula' => $payload['cedula'],
            'email' => $payload['email'],
        ]);
    }

    public function test_index_socios_requires_authentication()
    {
        $response = $this->getJson('/api/socios');

        $response->assertStatus(401);
    }

    public function test_update_socio_requires_authentication()
    {
        $socio = Socio::factory()->create();

        $payload = ['nombre' => 'Sin Auth'];

        $response = $this->putJson('/api/socios/' . $socio->cedula, $payload);

        $response->assertStatus(401);
    }

    public function test_create_socio_validation_errors_agrupado()
    {

        $payload = Socio::factory()->make()->toArray();
        unset($payload['cedula']);
        $response = $this->postJson('/api/socios', $payload);
        $response->assertStatus(422)->assertJsonValidationErrors(['cedula']);


        $payload = Socio::factory()->make()->toArray();
        $payload['email'] = 'not-an-email';
        $response = $this->postJson('/api/socios', $payload);
        $response->assertStatus(422)->assertJsonValidationErrors(['email']);


        $existing = Socio::factory()->create();
        $payload = Socio::factory()->make(['cedula' => $existing->cedula])->toArray();
        $response = $this->postJson('/api/socios', $payload);
        $response->assertStatus(422)->assertJsonValidationErrors(['cedula']);
    }

    public function test_update_socio_success()
    {
        $socio = Socio::factory()->create();
        $user = \App\Models\User::factory()->create();

        \Laravel\Passport\Passport::actingAs($user, ['*']);

        $payload = ['nombre' => 'Nombre Actualizado', 'email' => 'nuevoemail@example.com'];

        $response = $this->putJson('/api/socios/' . $socio->cedula, $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['nombre' => 'Nombre Actualizado', 'email' => 'nuevoemail@example.com']);

        $this->assertDatabaseHas('socios', ['cedula' => $socio->cedula, 'email' => 'nuevoemail@example.com']);
    }

    public function test_update_socio_unique_email_validation()
    {
        $socio1 = Socio::factory()->create();
        $socio2 = Socio::factory()->create();
        $user = \App\Models\User::factory()->create();
        \Laravel\Passport\Passport::actingAs($user, ['*']);

        $payload = ['email' => $socio2->email];

        $response = $this->putJson('/api/socios/' . $socio1->cedula, $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_update_socio_not_found()
    {
        $user = \App\Models\User::factory()->create();
        \Laravel\Passport\Passport::actingAs($user, ['*']);

        $response = $this->putJson('/api/socios/99999999', ['nombre' => 'X']);
        $response->assertStatus(404);
    }
}
