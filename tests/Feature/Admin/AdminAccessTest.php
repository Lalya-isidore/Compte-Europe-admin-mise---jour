<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_without_admin_session_is_redirected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.support.index'));

        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('error');
    }

    public function test_login_rejects_non_admin_credentials(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        Session::start();

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'user@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertFalse(Session::get('admin_authenticated', false));
    }

    public function test_login_accepts_admin_credentials(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        Session::start();

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'lalyaisidore@gmail.com',
            'password' => 'Lalyaisidore1@gmail.com',
        ]);

        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success');
        $this->assertTrue(Session::get('admin_authenticated'));
    }

    public function test_unread_count_endpoint_requires_admin_session(): void
    {
        $response = $this->get(route('admin.support.unread-count'));

        $response->assertRedirect(route('admin.index'));
    }

    public function test_unread_count_endpoint_returns_unread_message_total(): void
    {
        Session::start();
        Session::put('admin_authenticated', true);

        $user = User::factory()->create();

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'subject' => 'Demande en attente',
            'status' => 'pending',
            'last_message_at' => now(),
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'sent_by_admin' => false,
            'content' => "Bonjour, besoin d'aide",
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'sent_by_admin' => false,
            'content' => 'Autre message déjà lu',
            'read_at' => now(),
        ]);

        $response = $this->withSession(['admin_authenticated' => true])
            ->getJson(route('admin.support.unread-count'));

        $response->assertOk();
        $response->assertJson(['count' => 1]);
    }
}
