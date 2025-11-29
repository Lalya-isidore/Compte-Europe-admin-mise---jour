<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Compte;
use App\Models\Transfer;
use App\Models\TransactionHistory;
use App\Models\Remboursement;

class RefundAndBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_solde_creates_transaction_history()
    {
        // Create user and compte
        $user = User::factory()->create();
        $compte = Compte::create([
            'user_id' => $user->id,
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'test@example.com',
            'phone_number' => '000',
            'country' => 'FR',
            'address' => 'Paris',
            'devise' => 'XOF',
            'lang' => 'fr',
            'account_balance' => 1000,
            'account_balance2' => 1000,
            'account_type' => 'Test',
            'code_virement' => '123456',
            'account_status' => 'Activé',
            'transfer_supported' => 'Oui',
            'card_number' => '4111********1111',
            'cvv' => '123',
            'start_percentage' => '0',
            'end_percentage' => '100',
            'failure_message' => '',
            'password' => 'secret',
            'token' => null,
            'iban' => null,
            'parameters' => null,
            'is_default' => false,
            'numerocompte' => Compte::generateAccountNumber(),
        ]);

        $this->actingAs($user)
            ->put(route('update.solde', ['id' => $compte->id]), ['montant' => 500]);

        $this->assertDatabaseHas('transaction_histories', [
            'user_id' => $user->id,
            'transaction_type' => 'Funds added',
            'amount' => 500,
        ]);
    }

    public function test_rembourser_compte_creates_remboursement_and_history()
    {
        $user = User::factory()->create();
        $compte = Compte::create([
            'user_id' => $user->id,
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'test2@example.com',
            'phone_number' => '000',
            'country' => 'FR',
            'address' => 'Paris',
            'devise' => 'XOF',
            'lang' => 'fr',
            'account_balance' => 0,
            'account_balance2' => 0,
            'account_type' => 'Test',
            'code_virement' => '123456',
            'account_status' => 'Activé',
            'transfer_supported' => 'Oui',
            'card_number' => '4111********1111',
            'cvv' => '123',
            'start_percentage' => '0',
            'end_percentage' => '100',
            'failure_message' => '',
            'password' => 'secret',
            'token' => null,
            'iban' => null,
            'parameters' => null,
            'is_default' => false,
            'numerocompte' => Compte::generateAccountNumber(),
        ]);

        // Create a completed transfer for this user
        $transfer = Transfer::create([
            'user_id' => $user->id,
            'solidvire' => 1000,
            'devise' => 'XOF',
            'token' => 'mock-token',
            'numerocompte' => 'DEST-123',
            'name_servieur' => 'Service',
            'beneficiary_name' => 'B',
            'reason' => 'test',
            'status' => 'completed',
        ]);

        $this->actingAs($user)
            ->post(route('comptes.rembourserCompte', ['id' => $compte->id]));

        $this->assertDatabaseHas('transaction_histories', [
            'user_id' => $user->id,
            'transaction_type' => 'Refund received',
            'amount' => $transfer->solidvire,
        ]);

        $this->assertDatabaseHas('remboursements', [
            'compte_id' => $compte->id,
            'montant' => $transfer->solidvire,
        ]);
    }
}
