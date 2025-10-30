<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\DB;

trait CreatesOauthClient
{
    protected function createPasswordClient(): array
    {
        $clientId = DB::table('oauth_clients')->insertGetId([
            'name' => 'Test Password Grant Client',
            'secret' => 'test-secret',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'client_id' => $clientId,
            'client_secret' => 'test-secret',
        ];
    }

    protected function getOrCreatePasswordClient(): array
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->where('revoked', false)
            ->first();

        if ($client) {
            return [
                'client_id' => $client->id,
                'client_secret' => $client->secret,
            ];
        }

        return $this->createPasswordClient();
    }
}
