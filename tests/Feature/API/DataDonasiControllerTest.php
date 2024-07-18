<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DataDonasiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat pengguna dengan peran 'User'
        $this->user = User::factory()->create([
            'role' => 'User',
            'password' => Hash::make('password'),
        ]);
    }

    /** @test */
    public function user_can_access_data_user_index()
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->getJson('/api/admin/manajemen/data-donasi');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data user successfull',
            ]);
    }

    /** @test */
public function user_can_store_data_user()
{
    $this->actingAs($this->user, 'sanctum');

    $data = [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'username' => 'testuser',
        'alamat' => '123 Test Street',
        'telephone' => '1234567890',
        'password' => 'password',
        'confirm_password' => 'password',
    ];

    $response = $this->postJson('/api/admin/manajemen/data-donasi', $data);

    $response->assertStatus(201) // Mengharapkan status code 201
        ->assertJson([
            'success' => true,
            'message' => 'Create Berhasil',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'testuser@example.com',
        'username' => 'testuser',
    ]);
}


    /** @test */
    public function user_can_edit_data_user()
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->getJson('/api/admin/manajemen/data-donasi/edit/' . $this->user->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User data retrieved successfully',
            ]);
    }

    /** @test */
    public function user_can_update_data_user()
    {
        $this->actingAs($this->user, 'sanctum');

        $data = [
            'name' => 'Updated User',
            'email' => 'updateduser@example.com',
            'username' => 'updateduser',
            'alamat' => '123 Updated Street',
            'telephone' => '0987654321',
        ];

        $response = $this->putJson('/api/admin/manajemen/data-donasi/update/' . $this->user->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Update Berhasil',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'updateduser@example.com',
            'username' => 'updateduser',
        ]);
    }

    /** @test */
    public function user_can_destroy_data_user()
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->deleteJson('/api/admin/manajemen/data-donasi/delete/' . $this->user->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'data donasi has been removed',
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
    }
}
