<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProgramControllerTest extends TestCase
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
    public function user_can_access_program_index()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        Program::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/program');

        Log::info($response->getContent());

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'succes',
                     'message' => 'Get data program successful',
                 ]);
    }

    /** @test */
    public function user_cannot_access_program_index()
    {
        $response = $this->getJson('/api/admin/manajemen/program');
        
        Log::info($response->getContent());

        $response->assertStatus(401); // Unauthorized
    }
 
     /** @test */
     public function user_can_store_program()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $response = $this->postJson('/api/admin/manajemen/program', [
             'nama_program' => 'Program Test',
             'deskripsi' => 'ujicoba',
             'file' => UploadedFile::fake()->image('program.jpg'),
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Add program seccessfull',
             ]);
     }
 
     /** @test */
     public function user_cannot_store_program()
     {
        $this->actingAs($this->adminUser, 'sanctum');

         $response = $this->postJson('/api/admin/manajemen/program', [
             'nama_program' => '', 
             'deskripsi' => '', 
             'file' => '',
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['nama_program', 'deskripsi']);
     }
 
     /** @test */
     public function user_can_edit_program()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $program = Program::factory()->create();
 
         $response = $this->getJson('/api/admin/manajemen/program/edit/' . $program->id);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Get program successful',
             ]);
     }

    /** @test */
    public function user_can_update_an_program()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $programs = Program::factory()->create();

        $data = [
            'nama_program' => 'Updated Program',
            'deskripsi' => 'Update Deskripsi',
            'file' => UploadedFile::fake()->image('new_program.jpg'),
        ];

        $response = $this->putJson("/api/admin/manajemen/program/update/{$programs->id}", $data);

        Log::info($response->getContent());

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Update program successful',
                 ]);
    }

    /** @test */
    public function user_cannot_update_an_program()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $programs = Program::factory()->create();

        $data = [
            'nama_program' => '', 
            'deskripsi' => '', 
            'file' => UploadedFile::fake()->image('new_program.jpg'),
        ];

        $response = $this->putJson("/api/admin/manajemen/program/update/{$programs->id}", $data);

        Log::info($response->getContent());

        $response->assertStatus(422) // Unprocessable Entity
                 ->assertJsonValidationErrors(['nama_program', 'deskripsi']);
    }
 
     /** @test */
     public function user_can_destroy_program()
     {

         $this->actingAs($this->adminUser, 'sanctum');
 
         $program = Program::factory()->create();
 
         $response = $this->deleteJson("/api/admin/manajemen/program/delete/{$program->id}");

         $response->assertStatus(Response::HTTP_OK)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Program has been removed',
             ]);
     }
}
