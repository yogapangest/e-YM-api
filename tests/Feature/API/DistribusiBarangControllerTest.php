<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\Distribusi;
use Illuminate\Http\Response;
use App\Models\DistribusiBarang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DistribusiBarangControllerTest extends TestCase
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
     public function user_can_access_distribusibarang_index()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $distribusi = Distribusi::factory()->create();
 
         $response = $this->getJson('/api/admin/manajemen/distribusi-barang/' . $distribusi->id);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Get data distribusi barang successful',
             ]);
     }
 
     /** @test */
     public function user_cannot_access_distribusibarang_index()
     {
         $distribusi = Distribusi::factory()->create();
 
         $response = $this->getJson('/api/admin/manajemen/distribusi-barang/' . $distribusi->id);
 
         Log::info($response->getContent());
 
         $response->assertStatus(401);
     }
 
     /** @test */
    public function user_can_store_distribusibarang()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $distribusiId = Distribusi::factory()->create()->id;

        $response = $this->postJson('/api/admin/manajemen/distribusi-barang', [
            'distribusis_id' => $distribusiId,
            'nama_barang' => 'Test Barang',
            'volume' => 10,
            'satuan' => 'nota',
            'harga_satuan' => 100,
        ]);

        Log::info($response->getContent());

        // Handle both 200 and 400 responses based on validation outcome
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Add distribusi barang successful',
            ])
            ->assertJsonMissing([
                'status' => 'error',
                'message' => 'Total Harga Barang Melebihi Pengeluaran Yang Tertulis',
            ]);
    }
 
     /** @test */
     public function user_cannot_store_distribusi_barang()
     {
        $this->actingAs($this->adminUser, 'sanctum');

         $response = $this->postJson('/api/admin/manajemen/distribusi-barang', [
             'nama_barang' => '', // nama barang tidak boleh kosong
             'volume' => '',
             'satuan' => '',
             'harga_satuan' => '',
             'distribusis_id' => '', // id distribusi tidak boleh kosong
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['distribusis_id', 'nama_barang', 'volume', 'satuan', 'harga_satuan']);
     }
 
     /** @test */
     public function user_can_edit_distribusi_barang()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $distribusibarang = Distribusibarang::factory()->create();
 
         $response = $this->getJson('/api/admin/manajemen/distribusi-barang/edit/' . $distribusibarang->id);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Get distribusi barang successful',
             ]);
     }

     /** @test */
     public function user_can_update_distribusi_barang()
     {
         $this->actingAs($this->adminUser, 'sanctum');
 
         $distribusi = Distribusi::factory()->create(['anggaran' => 50000]);
         $distribusiBarang = DistribusiBarang::factory()->create([
             'distribusis_id' => $distribusi->id,
             'nama_barang' => 'Barang Test',
             'volume' => 10,
             'satuan' => 'kuitansi',
             'harga_satuan' => 1000,
         ]);
 
         $response = $this->putJson('/api/admin/manajemen/distribusi-barang/update/' . $distribusiBarang->id, [
             'distribusis_id' => $distribusi->id,
             'nama_barang' => 'Barang Test Updated',
             'volume' => 20,
             'satuan' => 'kuitansi',
             'harga_satuan' => 2000,
         ]);
 
         Log::info($response->getContent());
 
         $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Update distribusi barang successful',
             ]);
 
         $this->assertDatabaseHas('distribusi_barangs', [
             'id' => $distribusiBarang->id,
             'nama_barang' => 'Barang Test Updated',
             'volume' => 20,
             'satuan' => 'kuitansi',
             'harga_satuan' => 2000,
             'jumlah' => 40000, // volume * harga_satuan
         ]);
     }

    /** @test */
    public function user_cannot_update_distribusi_barang_with_invalid_data()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $distribusi = Distribusi::factory()->create();
        $distribusiBarang = DistribusiBarang::factory()->create();

        $response = $this->putJson('/api/admin/manajemen/distribusi-barang/update/' . $distribusiBarang->id, [
            'distribusis_id' => '', // invalid distribusis_id
            'nama_barang' => '',
            'volume' => '',
            'satuan' => '',
            'harga_satuan' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['distribusis_id', 'nama_barang', 'volume', 'satuan', 'harga_satuan']);
    }

 
     /** @test */
    public function user_can_destroy_distribusibarang()
    {
        $this->actingAs($this->adminUser, 'sanctum');

        $distribusibarang = DistribusiBarang::factory()->create();

        $response = $this->deleteJson('/api/admin/manajemen/distribusi-barang/delete/' . $distribusibarang->id);

        Log::info($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Distribusi barang has been removed',
            ]);
    }
}
