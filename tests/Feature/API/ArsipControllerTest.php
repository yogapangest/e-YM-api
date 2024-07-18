<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\Arsip;
use App\Models\Program;
use App\Models\JenisArsip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArsipControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'Admin',
            'password' => Hash::make('password'),
        ]);

        // Create valid program and jenis arsip for testing
        Program::factory()->create(['id' => 1]);
        JenisArsip::factory()->create(['id' => 1]);
    }

    /** @test */
    public function user_can_access_arsip_index()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        Arsip::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/arsip');

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data arsip successful',
            ]);
    }

    /** @test */
    public function user_cannot_access_arsip_index()
    {
        $response = $this->getJson('/api/admin/manajemen/arsip');

        Log::info($response->getContent());

        $response->assertStatus(401);
    }

    /** @test */
    public function user_can_store_arsip()
    {
        $this->withoutExceptionHandling();

        // Acting as admin (adjust as per your authentication setup)
        $this->actingAs($this->adminUser, 'sanctum');

        // Mock file upload (if needed), adjust as per your file handling
        $file = UploadedFile::fake()->image('test_image.jpg');

        $response = $this->postJson('/api/admin/manajemen/arsip', [
            'file' => $file, // provide a valid file for testing
            'programs_id' => 1, // use valid program id
            'jenisarsips_id' => 1, // use valid jenis arsip id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Add arsip successful',
            ]);

        // Optionally, assert database has the created arsip
        $this->assertDatabaseHas('arsips', [
            'programs_id' => 1, // check for the valid program id
            'jenisarsips_id' => 1, // check for the valid jenis arsip id
        ]);
    }

    /** @test */
    public function user_cannot_store_arsip()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $response = $this->postJson('/api/admin/manajemen/arsip', [
            'file' => '', // adjust as per your validation rules
            'programs_id' => '', // invalid program id
            'jenisarsips_id' => '', // invalid jenis arsip id
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['programs_id', 'jenisarsips_id']);
    }

    /** @test */
    public function user_can_edit_arsip()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $arsip = Arsip::factory()->create();

        $response = $this->getJson('/api/admin/manajemen/arsip/edit/' . $arsip->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get arsip successful',
            ]);
    }

    /** @test */
    public function user_can_update_arsip()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->adminUser, 'sanctum');

        $arsip = Arsip::factory()->create([
            'programs_id' => 1,
            'jenisarsips_id' => 1,
        ]);

        $file = UploadedFile::fake()->image('updated_image.jpg');

        $response = $this->putJson('/api/admin/manajemen/arsip/update/' . $arsip->id, [
            'file' => $file,
            'programs_id' => 1,
            'jenisarsips_id' => 1,
        ]);

        Log::info($response->getContent()); // Log full response content for debugging

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Update arsip successful',
            ]);

        $this->assertDatabaseHas('arsips', [
            'id' => $arsip->id,
            'programs_id' => 1,
            'jenisarsips_id' => 1,
        ]);
    }


    /** @test */
    public function user_cannot_update_arsip_with_invalid_data()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $arsip = Arsip::factory()->create([
            'programs_id' => 1,
            'jenisarsips_id' => 1,
        ]);

        $response = $this->putJson('/api/admin/manajemen/arsip/update/' . $arsip->id, [
            'file' => null,
            'programs_id' => 999, // Provide an invalid program_id
            'jenisarsips_id' => 999, // Provide an invalid jenisarsips_id
        ]);

        Log::info($response->getContent());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['programs_id', 'jenisarsips_id']);
    }

     /** @test */
     public function user_can_destroy_arsip()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $arsip = Arsip::factory()->create();
 
         $response = $this->deleteJson('/api/admin/manajemen/arsip/delete/' . $arsip->id);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'arsip has been removed',
             ]);
     }

}
