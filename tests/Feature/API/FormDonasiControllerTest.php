<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\BuktiDonasi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormDonasiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'User',
            'password' => Hash::make('password'),
        ]);
    }

    /** @test */
    public function user_can_access_donasi_index()
    {
        $this->actingAs($this->user, 'sanctum');

        BuktiDonasi::factory()->create([
            'users_id' => $this->user->id,
        ]);

        $response = $this->getJson('/api/user/manajemen/formdonasi/' . $this->user->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data donasi successful',
            ]);
    }

    /** @test */
    public function user_cannot_access_donasi_index()
    {
        $response = $this->getJson('/api/user/manajemen/formdonasi/' . $this->user->id);

        Log::info($response->getContent());

        $response->assertStatus(401);
    }

    /** @test */
    public function user_can_store_donasi()
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->postJson('/api/user/manajemen/formdonasi', [
            'nominal' => '1000000',
            'deskripsi' => 'Donasi untuk program A',
            'file' => null,
            'users_id' => $this->user->id,
        ]);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Add donasi seccessfull',
            ]);
    }

    /** @test */
    public function user_cannot_store_donasi_with_invalid_data()
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->postJson('/api/user/manajemen/formdonasi', [
            'nominal' => '',
            'deskripsi' => '',
            'file' => '',
            'users_id' => $this->user->id,
        ]);

        Log::info($response->getContent());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nominal', 'deskripsi']);
    }

    /** @test */
    public function user_can_edit_donasi()
    {
        $this->actingAs($this->user, 'sanctum');

        $donasi = BuktiDonasi::factory()->create();

        $response = $this->getJson('/api/user/manajemen/formdonasi/edit/' . $donasi->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get donasi successful',
            ]);
    }

    /** @test */
    public function user_can_update_donasi()
    {
        $this->actingAs($this->user, 'sanctum');

        $donasi = BuktiDonasi::factory()->create();

        $response = $this->putJson('/api/user/manajemen/formdonasi/update/' . $donasi->id, [
            'nominal' => '1500000',
            'deskripsi' => 'Update donasi untuk program B',
            'file' => null,
            'users_id' => $this->user->id,
        ]);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Update donasi seccesfull',
            ]);
    }

    /** @test */
    public function user_cannot_update_donasi_with_invalid_data()
    {
        $this->actingAs($this->user, 'sanctum');

        $donasi = BuktiDonasi::factory()->create();

        $response = $this->putJson('/api/user/manajemen/formdonasi/update/' . $donasi->id, [
            'nominal' => '',
            'deskripsi' => '',
            'file' => null,
            'users_id' => $this->user->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nominal', 'deskripsi']);
    }

    /** @test */
    public function user_can_destroy_donasi()
    {
        $this->actingAs($this->user, 'sanctum');

        $donasi = BuktiDonasi::factory()->create();

        $response = $this->deleteJson("/api/user/manajemen/formdonasi/delete/{$donasi->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'seccess',
                'message' => 'donasi has been removed',
            ]);
    }
}

