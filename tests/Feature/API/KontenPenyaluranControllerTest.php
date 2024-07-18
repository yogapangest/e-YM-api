<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\KontenPenyaluran;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KontenPenyaluranControllerTest extends TestCase
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
    public function user_can_access_konten_penyaluran_index()
    {
        $this->actingAs($this->admin, 'sanctum');

        KontenPenyaluran::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/kontenpenyaluran');

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data konten penyaluran successfull',
            ]);
    }
    /** @test */
    public function user_cannot_access_konten_penyaluran_index()
    {
        $response = $this->getJson('/api/admin/manajemen/kontenpenyaluran');

        Log::info($response->getContent());

        $response->assertStatus(401);
    }
    
    
        //test store endpoint 
        /** @test */
        public function user_can_store_konten_penyaluran()
        {
            $this->actingAs($this->admin, 'sanctum');
    
            $response = $this->postJson('/api/admin/manajemen/kontenpenyaluran', [
                'nama_penyaluran' => 'Konten Test',
                'deskripsi' => 'Test Deskripsi',
                'foto' => null,
            ]);
    
            Log::info($response->getContent());
    
            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Add konten penyaluran seccessfull',
                ]);
        }
    
        /** @test */
        public function user_cannot_store_konten_penyaluran_with_invalid_data()
        {
            $this->actingAs($this->admin, 'sanctum');
    
            $response = $this->postJson('/api/admin/manajemen/kontenpenyaluran', [
                'nama_penyaluran' => '',
                'deskripsi' => '',
                'foto' => '',
            ]);
    
            Log::info($response->getContent());
    
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['nama_penyaluran', 'deskripsi']);
        }
    
        //test edit endpoint
        /** @test */
        public function user_can_edit_konten_penyaluran()
        {
            $this->actingAs($this->admin, 'sanctum');
    
            $kontenPenyaluran = KontenPenyaluran::factory()->create();
    
            $response = $this->getJson('/api/admin/manajemen/kontenpenyaluran/edit/' . $kontenPenyaluran->id);
    
            Log::info($response->getContent());
    
            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Get konten penyaluran successful',
                ]);
        }
        
        //test update endpoint
        /** @test */
        public function user_can_update_konten_penyaluran()
        {
            $this->actingAs($this->admin, 'sanctum');
    
            $kontenPenyaluran = KontenPenyaluran::factory()->create();
    
            $response = $this->putJson('/api/admin/manajemen/kontenpenyaluran/update/' . $kontenPenyaluran->id, [
                'nama_penyaluran' => 'Updated Konten',
                'deskripsi' => 'Updated Deskripsi',
                'foto' => UploadedFile::fake()->image('new_kontenpenyaluran.jpg'),
            ]);
    
            Log::info($response->getContent());
    
            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Update konten penyaluran successful',
                ]);
        }
    
        /** @test */
        public function user_cannot_update_konten_penyaluran_with_invalid_data()
        {
            $this->actingAs($this->admin, 'sanctum');
    
            $kontenPenyaluran = KontenPenyaluran::factory()->create();
    
            $response = $this->putJson('/api/admin/manajemen/kontenpenyaluran/update/' . $kontenPenyaluran->id, [
                'nama_penyaluran' => '',
                'deskripsi' => '',
                'foto' => '',
            ]);
            Log::info($response->getContent());

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['nama_penyaluran', 'deskripsi']);
        }
    
        //test destroy endpoint
        /** @test */
        public function user_can_destroy_konten_penyaluran()
        {
            $this->actingAs($this->admin, 'sanctum');
    
            $kontenPenyaluran = KontenPenyaluran::factory()->create();
    
            $response = $this->deleteJson('/api/admin/manajemen/kontenpenyaluran/delete/' . $kontenPenyaluran->id);
    
            Log::info($response->getContent());
    
            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Konten penyaluran has been removed',
                ]);
        }
}
