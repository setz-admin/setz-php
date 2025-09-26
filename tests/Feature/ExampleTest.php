<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testet, dass ein Gast zur Login-Seite weitergeleitet wird.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        // Assert: Der Statuscode sollte 302 (Redirect) sein
        $response->assertStatus(302);

        // Assert: Die Weiterleitung sollte zur /login-Route erfolgen
        $response->assertRedirect('/login');
    }

    /**
     * Testet, dass ein authentifizierter Nutzer das Dashboard sehen kann.
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        // Arrange: Erzeuge einen temporären Nutzer, der für den Test angemeldet wird
        $user = User::factory()->create();

        // Act: Führe die Anfrage als dieser Nutzer aus
        $response = $this->actingAs($user)->get('/dashboard');

        // Assert: Die Anfrage sollte erfolgreich sein (Statuscode 200)
        $response->assertStatus(200);

        // Assert: Der erwartete Text sollte auf der Seite sichtbar sein
        $response->assertSee('Dashboard');
    }
}
