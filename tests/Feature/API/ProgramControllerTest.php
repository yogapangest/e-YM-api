<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProgramControllerTest extends TestCase
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

     /** @test */
     public function user_can_access_program_index()
     {

         Program::factory()->create();
 
         $response = $this->getJson('/api/admin/manajemen/program');
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'succes',
                 'message' => 'Get data program successfull',
             ]);
     }
 
     /** @test */
     public function user_cannot_access_program_index()
     {
        $this->actingAs($this->admin, 'sanctum');

         $response = $this->getJson('/api/admin/manajemen/program');
 
         Log::info($response->getContent());
 
         $response->assertStatus(401);
     }
 
     /** @test */
     public function user_can_store_program()
     {
         $this->actingAs($this->admin, 'sanctum');
 
         $response = $this->postJson('/api/admin/manajemen/program', [
             'nama_program' => 'Program Test',
             'deskripsi' => 'ujicoba',
             'file' => null,
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
         $this->actingAs($this->admin, 'sanctum');
 
         $response = $this->postJson('/api/admin/manajemen/program', [
             'nama_program' => '', // nama program tidak boleh kosong
             'deskripsi' => '', // deskripsi tidak boleh kosong
             'file' => '',
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['nama_program', 'deskripsi']);
     }
 
     /** @test */
     public function user_can_edit_program()
     {
         $this->actingAs($this->admin, 'sanctum');
 
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
     public function user_can_update_program()
     {
         $this->actingAs($this->admin, 'sanctum');
 
         $program = Program::factory()->create();
 
         $response = $this->putJson('/api/admin/manajemen/program/update/' . $program->id, [
             'nama_program' => 'Updated Program',
             'deskripsi' => 'Updated Description',
             'file' => null,
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Update program successful',
             ]);
     }
     /** @test */
     public function user_cannot_update_program_with_invalid_data()
     {
         $this->actingAs($this->admin, 'sanctum');
 
         $program = Program::factory()->create();
 
         $response = $this->putJson('/api/admin/manajemen/program/update/' . $program->id, [
             'nama_program' => '',
             'deskripsi' => '',
             'file' => '',
         ]);
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['nama_program', 'deskripsi']);
     }
 
     /** @test */
     public function user_can_destroy_program()
     {
         // Create a user for testing
         $this->actingAs($this->admin, 'sanctum');
 
         // Create a program to delete
         $program = Program::factory()->create();
 
         // Make the delete request
         $response = $this->deleteJson("/api/admin/manajemen/program/delete/{$program->id}");
 
         // Assert response
         $response->assertStatus(Response::HTTP_OK)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Program has been removed',
             ]);
     }
}
