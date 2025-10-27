<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\CreatesOauthClient;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\User;
class UserTest extends TestCase
{
    use RefreshDatabase, CreatesOauthClient;
    use \Illuminate\Foundation\Testing\WithFaker;

    private function actingUserSocio()
    {
        $user = User::factory()->create([
            'cedula' => '90000010',
            'password' => bcrypt('90000010'),
            'email' => 'foto@example.com'
        ]);
        \App\Models\Socio::factory()->create([
            'cedula' => $user->cedula,
            'email' => $user->email
        ]);
        \Laravel\Passport\Passport::actingAs($user, ['*']);
        return $user;
    }

    public function test_subida_foto_perfil_exitosa()
    {
        Storage::fake('public');
        $user = $this->actingUserSocio();
        $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg', 300, 300)->size(500);
        $response = $this->postJson('/api/perfil/foto', ['foto' => $file]);
        $response->assertStatus(200);
        $socio = \App\Models\Socio::where('cedula', $user->cedula)->first();
        $this->assertTrue(Storage::disk('public')->exists($socio->foto_perfil));
    }

    public function test_subida_foto_perfil_errores_validacion()
    {
        Storage::fake('public');
        $user = $this->actingUserSocio();

        $file = \Illuminate\Http\UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf');
        $response = $this->postJson('/api/perfil/foto', ['foto' => $file]);
        $response->assertStatus(422);

        $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg')->size(3000);
        $response = $this->postJson('/api/perfil/foto', ['foto' => $file]);
        $response->assertStatus(422);
    }
    public function test_ObtenerTokenConClientIdValido()
    {
        $user = User::factory()->create([
            'cedula' => '90000001',
            'password' => bcrypt('90000001')
        ]);

        $client = $this->createPasswordClient();

        $response = $this->post('/oauth/token', [
            'username' => $user->cedula,
            'password' => '90000001',
            'grant_type' => 'password',
            'client_id' => $client['client_id'],
            'client_secret' => $client['client_secret'],
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "token_type",
            "expires_in",
            "access_token",
            "refresh_token"
        ]);

        $response->assertJsonFragment([
            "token_type" => "Bearer"
        ]);
    }

    public function test_ObtenerTokenConClientIdInvalido()
    {
        $response = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => '234',
            'client_secret' => Str::random(8),
        ]);

        $response->assertStatus(401);

        $response->assertJsonFragment([
            "error" => "invalid_client",
            "error_description" => "Client authentication failed",
            "message" => "Client authentication failed"
        ]);
    }

    public function test_ValidarTokenSinEnviarToken()
    {
        $response = $this->getJson('/api/validate');

        $response->assertStatus(401);
    }

    public function test_ValidarTokenConTokenInvalido()
    {
        $response = $this->getJson('/api/validate', [
            'Authorization' => 'Bearer ' . Str::random(40),
        ]);

        $response->assertStatus(401);
    }

    public function test_ValidarTokenConTokenValido()
    {
        $user = User::factory()->create([
            'cedula' => '90000002',
            'password' => bcrypt('90000002')
        ]);

        $client = $this->createPasswordClient();

        $tokenResponse = $this->post('/oauth/token', [
            'username' => $user->cedula,
            'password' => '90000002',
            'grant_type' => 'password',
            'client_id' => $client['client_id'],
            'client_secret' => $client['client_secret'],
        ]);

        $token = json_decode($tokenResponse->content(), true);

        $response = $this->getJson('/api/validate', [
            'Authorization' => 'Bearer ' . ($token['access_token'] ?? ''),
        ]);

        $response->assertStatus(200);
    }

    public function test_LogoutSinToken()
    {
        $response = $this->getJson('/api/logout');

        $response->assertStatus(401);
    }

    public function test_LogoutConTokenInvalido()
    {
        $response = $this->getJson('/api/logout', [
            'Authorization' => 'Bearer ' . Str::random(40),
        ]);

        $response->assertStatus(401);
    }

    public function test_LogoutConTokenValido()
    {
        $user = User::factory()->create([
            'cedula' => '90000002',
            'password' => bcrypt('90000002')
        ]);

        $client = $this->createPasswordClient();

        $tokenResponse = $this->post('/oauth/token', [
            'username' => $user->cedula,
            'password' => '90000002',
            'grant_type' => 'password',
            'client_id' => $client['client_id'],
            'client_secret' => $client['client_secret'],
        ]);

        $token = json_decode($tokenResponse->content(), true);

        $response = $this->getJson('/api/logout', [
            'Authorization' => 'Bearer ' . ($token['access_token'] ?? ''),
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'message' => 'Token Revoked'
        ]);
    }
}
