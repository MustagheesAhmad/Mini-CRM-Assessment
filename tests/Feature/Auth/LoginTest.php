<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('secret123'),
            'role'     => UserRole::User,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'test@example.com',
            'password' => 'secret123',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['user', 'token'],
            ])
            ->assertJson(['success' => true]);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create(['email' => 'test@example.com']);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_login_requires_email_and_password(): void
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonStructure(['errors']);
    }

    public function test_login_rejects_invalid_email_format(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'not-an-email',
            'password' => 'secret123',
        ]);

        $response->assertStatus(422);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $this->withToken($token)
            ->postJson('/api/auth/logout')
            ->assertOk()
            ->assertJson(['success' => true]);

        // The token record should be removed from the database
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $this->getJson('/api/leads')->assertUnauthorized();
    }
}
