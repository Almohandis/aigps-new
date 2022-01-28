<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\NationalId;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        NationalId::create([
            'national_id' => 555,
        ]);

        $this->withoutExceptionHandling();
    }

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'national_id' => 555,
        ]);

        $response = $this->post('/login', [
            'national_id' => 555,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $user = User::factory()->create([
            'national_id' => 555,
        ]);

        $this->post('/login', [
            'national_id' => 555,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
