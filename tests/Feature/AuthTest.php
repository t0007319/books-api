<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test successful login.
     *
     * @return void
     */
    public function testLoginSuccess(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password123'), // Make sure to hash the password
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * Test login with incorrect password.
     *
     * @return void
     */
    public function testLoginWithIncorrectPassword(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'incorrect_password', // Provide incorrect password
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorised']);
    }

    /**
     * Test login with invalid email.
     *
     * @return void
     */
    public function testLoginWithInvalidEmail(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid_email', // Provide invalid email
            'password' => 'Password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email' => 'The email must be a valid email address.']);
    }

}
