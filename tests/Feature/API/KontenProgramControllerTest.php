<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\KontenProgram;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KontenProgramControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'Admin',
            'password' => Hash::make('password'),
        ]);
    }

    //test index endpoint
        /** @test */
    public function user_can_access_konten_program_index()
    {
        $this->actingAs($this->admin, 'sanctum');

        KontenProgram::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/kontenprogram');

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data konten program successfull',
            ]);
    }
    /** @test */
    public function user_cannot_access_konten_program_index()
    {
        $response = $this->getJson('/api/admin/manajemen/kontenprogram');

        Log::info($response->getContent());

        $response->assertStatus(401);
    }


    //test store endpoint 
    /** @test */
    public function user_can_store_konten_program()
    {
        $this->actingAs($this->admin, 'sanctum');

        $response = $this->postJson('/api/admin/manajemen/kontenprogram', [
            'nama_kontenprogram' => 'Konten Test',
            'foto' => null,
        ]);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Add konten program seccessfull',
            ]);
    }

    /** @test */
    public function user_cannot_store_konten_program_with_invalid_data()
    {
        $this->actingAs($this->admin, 'sanctum');

        $response = $this->postJson('/api/admin/manajemen/kontenprogram', [
            'nama_kontenprogram' => '',
            'foto' => '',
        ]);

        Log::info($response->getContent());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nama_kontenprogram']);
    }

    //test edit endpoint
    /** @test */
    public function user_can_edit_konten_program()
    {
        $this->actingAs($this->admin, 'sanctum');

        $kontenProgram = KontenProgram::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/kontenprogram/edit/' . $kontenProgram->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get konten program successful',
            ]);
    }
    
    //test update endpoint
    /** @test */
    public function user_can_update_konten_program()
    {
        $this->actingAs($this->admin, 'sanctum');

        $kontenProgram = KontenProgram::factory()->create();

        $response = $this->putJson('/api/admin/manajemen/kontenprogram/update/' . $kontenProgram->id, [
            'nama_kontenprogram' => 'Updated Konten',
            'foto' => null,
        ]);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Update konten program successful',
            ]);
    }

    /** @test */
    public function user_cannot_update_konten_program_with_invalid_data()
    {
        $this->actingAs($this->admin, 'sanctum');

        $kontenProgram = KontenProgram::factory()->create();

        $response = $this->putJson('/api/admin/manajemen/kontenprogram/update/' . $kontenProgram->id, [
            'nama_program' => '',
            'foto' => '',
        ]);

        Log::info($response->getContent());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nama_kontenprogram']);
    }

    //test destroy endpoint
    /** @test */
    public function user_can_destroy_konten_program()
    {
        $this->actingAs($this->admin, 'sanctum');

        $kontenProgram = KontenProgram::factory()->create();

        $response = $this->deleteJson('/api/admin/manajemen/kontenprogram/delete/' . $kontenProgram->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Konten program has been removed',
            ]);
    }
}
