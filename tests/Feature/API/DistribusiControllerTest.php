<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\Program;
use App\Models\Distribusi;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DistribusiControllerTest extends TestCase
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
    public function user_can_access_distribusi_index()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        Distribusi::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/distribusi');

        Log::info($response->getContent());

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'succes',
                     'message' => 'Get data distribusi successfull',
                 ]);
    }

    /** @test */
    public function user_cannot_access_distribusi_index()
    {
        $response = $this->getJson('/api/admin/manajemen/distribusi');
        
        Log::info($response->getContent());

        $response->assertStatus(401); // Unauthorized
    }
 
     /** @test */
     public function user_can_store_distribusi()
     {
         $this->actingAs($this->adminUser, 'sanctum');

         $programId = Program::factory()->create()->id;
 
         $response = $this->postJson('/api/admin/manajemen/distribusi', [
            'tanggal' => '2024-07-03',
            'tempat' => 'Test Place',
            'penerima_manfaat' => 'Test Penerima',
            'anggaran' => '5000',
            'pengeluaran' => '2000',
            'file' => UploadedFile::fake()->image('distribusi.jpg'),
            'programs_id' => $programId,
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Add distribusi successful',
             ]);
     }
 
     /** @test */
     public function user_cannot_store_distribusi()
     {
        $this->actingAs($this->adminUser, 'sanctum');

         $response = $this->postJson('/api/admin/manajemen/distribusi', [
            'tanggal' => '', // tanggal tidak boleh kosong
            'tempat' => '', // tempat tidak boleh kosong
            'penerima_manfaat' => '',
            'anggaran' => '',
            'pengeluaran' => '',
            'file' => '',
            'programs_id' => '',
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['tanggal', 'tempat','penerima_manfaat','anggaran','pengeluaran']);
     }
 
     /** @test */
     public function user_can_edit_distribusi()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $distribusi = Distribusi::factory()->create();
 
         $response = $this->getJson('/api/admin/manajemen/distribusi/edit/' . $distribusi->id);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Get distribusi successfull',
             ]);
     }

    /** @test */
    public function user_can_update_an_distribusi()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $programId = Program::factory()->create()->id;

        $distribusis = distribusi::factory()->create();

        $response = $this->putJson('/api/admin/manajemen/distribusi/update/' . $distribusis->id, [
            'tanggal' => '2024-06-02',
            'tempat' => 'Banyuwangi',
            'penerima_manfaat' => 'Yatim Piatu',
            'anggaran' => '5000',
            'pengeluaran' => '2000',
            'file' => UploadedFile::fake()->image('distribusi.jpg'),
            'programs_id' => $programId,
         ]);

        Log::info($response->getContent());

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Update distribusi successful',
                 ]);
    }

    /** @test */
    public function user_cannot_update_an_distribusi()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $programId = Program::factory()->create()->id;

        $distribusis = distribusi::factory()->create();

        $data = [
            'tanggal' => '',
            'tempat' => '',
            'penerima_manfaat' => '',
            'anggaran' => '',
            'pengeluaran' => '',
            'file' =>'',
            'programs_id' => ''
        ];

        $response = $this->putJson("/api/admin/manajemen/distribusi/update/{$distribusis->id}", $data);

        Log::info($response->getContent());

        $response->assertStatus(422) // Unprocessable Entity
                 ->assertJsonValidationErrors(['tanggal', 'tempat','penerima_manfaat','anggaran','pengeluaran']);
    }
 
     /** @test */
     public function user_can_destroy_distribusi()
     {

         $this->actingAs($this->adminUser, 'sanctum');
 
         $distribusi = Distribusi::factory()->create();
 
         $response = $this->deleteJson("/api/admin/manajemen/distribusi/delete/{$distribusi->id}");

         $response->assertStatus(Response::HTTP_OK)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Distribusi has been removed',
             ]);
     }
}
