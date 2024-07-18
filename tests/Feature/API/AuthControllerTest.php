<?php

namespace Tests\Feature\API;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_register_with_valid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
            'alamat' => '123 Main St',
            'telephone' => '1234567890',
            'password' => 'password123',
            'confirm_password' => 'password123',
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Registration successful',
                    'url' => '/apps/dashboard',
                ])
                ->assertCookie('access_token')
                ->assertJsonStructure([
                    'status',
                    'message',
                    'token',
                    'url'
                ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
        ]);
    }

    /** @test */
    public function user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'username' => '',
            'alamat' => '',
            'telephone' => '1234567890123456',
            'password' => 'short',
            'confirm_password' => 'different', 
        ]);

        $response->assertStatus(422) 
                ->assertJsonValidationErrors([
                    'name',
                    'email',
                    'username',
                    'alamat',
                    'telephone',
                    'password',
                    'confirm_password',
                ]);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Login successful',
                 ])
                 ->assertCookie('access_token');
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Unauthorized',
                 ])
                 ->assertCookieMissing('access_token');
    }

    /** @test */
    public function user_can_logout()
    {

        $user = User::factory()->create();
        
        $this->actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Logout successful',
                 ])
                 ->withoutCookie('access_token');
    }
}