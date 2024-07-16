<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisArsip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JenisArsipControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'Admin',
            'password' => Hash::make('password'),
        ]);
    }

    /** @test */
    public function user_can_access_jenisarsip_index()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        JenisArsip::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/jenis-arsip');

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data jenisarsip successfull',
            ]);
    }

    /** @test */
    public function user_cannot_access_jenisarsip_index()
    {
        $response = $this->getJson('/api/admin/manajemen/jenis-arsip');

        Log::info($response->getContent());

        $response->assertStatus(401);
    }

     /** @test */
     public function user_can_store_jenisarsip()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $response = $this->postJson('/api/admin/manajemen/jenis-arsip', [
             'nama_arsip' => 'Arsip Test',
             'deskripsi' => 'ujicoba',
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Add jenisarsip successful',
             ]);
     }
 
     /** @test */
     public function user_cannot_store_jenisarsip()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $response = $this->postJson('/api/admin/manajemen/jenis-arsip', [
             'nama_arsip' => '', // nama program tidak boleh kosong
             'deskripsi' => '', // deskripsi tidak boleh kosong
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['nama_arsip', 'deskripsi']);
     }

     /** @test */
    public function user_can_edit_jenisarsip()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $jenisarsip = JenisArsip::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/jenis-arsip/edit/' . $jenisarsip->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get jenisarsip successful',
            ]);
    }

    /** @test */
    public function user_can_update_jenisarsip()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $jenisarsip = JenisArsip::factory()->create();

        $response = $this->putJson('/api/admin/manajemen/jenis-arsip/update/' . $jenisarsip->id, [
            'nama_arsip' => 'Updated Jenis Arsip',
            'deskripsi' => 'Updated Description',
        ]);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Update jenisarsip successful',
            ]);
    }

    /** @test */
    public function user_cannot_update_an_jenisarsip()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $jenisarsip = JenisArsip::factory()->create();

        $data = [
            'nama_arsip' => '',
            'deskripsi' => '',
        ];

        $response = $this->putJson("/api/admin/manajemen/jenis-arsip/update/{$jenisarsip->id}", $data);

        Log::info($response->getContent());

        $response->assertStatus(422) // Unprocessable Entity
                 ->assertJsonValidationErrors(['nama_arsip', 'deskripsi']);
    }

    /** @test */
    public function user_can_destroy_jenisarsip()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $jenisarsip = JenisArsip::factory()->create();

        $response = $this->deleteJson('/api/admin/manajemen/jenis-arsip/delete/' . $jenisarsip->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'jenisarsip has been removed',
            ]);
    }
 
}
