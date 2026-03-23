<?php

namespace Tests\Feature;

use App\Models\Compte;
use App\Models\UnlockCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UnlockCodesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_consume_endpoint_marks_unlock_code_as_used(): void
    {
        config()->set('services.unlock_codes.api_key', 'test-key');

        $user = User::factory()->create();

        $compte = Compte::create([
            'user_id' => $user->id,
            'nom' => 'Tester',
            'prenom' => 'Client',
            'email' => 'tester@example.com',
            'password' => 'secret',
            'devise' => 'EUR',
            'lang' => 'fr',
            'phone_number' => '+33123456789',
            'country' => 'FR',
            'address' => '1 Rue de Test, Paris',
            'account_balance' => 0,
            'account_balance2' => 0,
            'code_virement' => '123456',
            'account_type' => 'standard',
            'account_status' => 'active',
            'transfer_supported' => 'yes',
            'card_number' => '4111111111111111',
            'cvv' => '123',
            'start_percentage' => '0',
            'end_percentage' => '100',
            'failure_message' => 'none',
            'token' => Str::random(20),
        ]);

        $response = $this->withHeaders([
            'X-API-Key' => 'test-key',
        ])->postJson('/api/unlock-codes/consume', [
            'code' => '123456',
            'compte_id' => $compte->id,
        ]);

        $response->assertOk()
            ->assertJson([
                'status' => 'ok',
                'compte_id' => $compte->id,
            ]);

        $unlockId = $response->json('unlock_id');
        $this->assertNotNull($unlockId);

        $unlock = UnlockCode::find($unlockId);

        $this->assertNotNull($unlock);
        $this->assertEquals($compte->id, $unlock->compte_id);
        $this->assertNotNull($unlock->used_at);
    }
}
