<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'Admin',
            'password' => Hash::make('password'),
        ]);
    }

   /** @test */
    public function user_can_edit_own_profile()
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/user/update-profile/edit');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User data retrieved successfully',
                'data' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'username' => $this->user->username,
                    'alamat' => $this->user->alamat,
                    'telephone' => $this->user->telephone,
                ],
            ]);
    }

    /** @test */
    public function user_can_update_profile()
    {
        $this->actingAs($this->user);

        $response = $this->putJson('/api/user/update-profile/update', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'username' => 'updated_username',
            'alamat' => 'Updated Address',
            'telephone' => '123456789',
            'password' => 'newpassword',
            'confirm_password' => 'newpassword',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Update Berhasil',
                'data' => [
                    'name' => 'Updated Name',
                    'email' => 'updated@example.com',
                    'username' => 'updated_username',
                    'alamat' => 'Updated Address',
                    'telephone' => '123456789',
                ],
            ]);

        // Ensure the password is not returned in the response
        $this->assertArrayNotHasKey('password', $response->json('data'));
    }


    /** @test */
    public function user_cannot_update_profile()
    {
        $response = $this->putJson('/api/user/update-profile/update', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'username' => 'updated_username',
            'alamat' => 'Updated Address',
            'telephone' => '123456789',
        ]);

        $response->assertStatus(401);
    }

}
