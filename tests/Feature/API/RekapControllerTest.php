<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\BuktiDonasi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RekapControllerTest extends TestCase
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
    public function user_can_access_donasi_index()
    {
        // Authenticate as the admin user
        $this->actingAs($this->admin, 'sanctum');

        // Create a user and related donations
        $user = User::factory()->create();
        $donations = BuktiDonasi::factory()->count(3)->create([
            'users_id' => $user->id,
        ]);

        // Make a GET request to the index method
        $response = $this->getJson("/api/admin/manajemen/rekap-donasi/{$user->id}");

        // Log the response content for debugging if needed
        Log::info($response->getContent());

        // Assert the response status and JSON structure
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get data donasi successful',
                // Ensure the 'donasi' key contains the expected donations data
                'donasi' => $donations->toArray(),
                'url' => '/admin/donasi',
            ]);
    }

    /** @test */
    public function user_cannot_access_rekap_index()
    {
        $user = User::factory()->create();
        $response = $this->getJson("/api/admin/manajemen/rekap-donasi/{$user->id}");

        Log::info($response->getContent());

        $response->assertStatus(401);
    }

    /** @test */
    public function user_can_store_rekap_donasi()
    {
        // Authentikasi sebagai admin
        $this->actingAs($this->admin, 'sanctum');

        // Membuat data BuktiDonasi untuk diuji
        $user = BuktiDonasi::factory()->create()->id;

        // Persiapan file untuk di-upload (contoh menggunakan file dummy)
        Storage::fake('public');
        $file = UploadedFile::fake()->image('donasi.jpg');

        // Mengirim permintaan POST JSON ke store method
        $response = $this->postJson('/api/admin/manajemen/rekap-donasi', [
            'tanggal' => '2024-07-03',
            'nominal' => '5000',
            'deskripsi' => 'Test Deskripsi',
            'file' => $file,
            'users_id' => $this->admin->id, // id pengguna yang terautentikasi
        ]);

        // Log isi respons untuk debugging jika diperlukan
        Log::info($response->getContent());

        // Memastikan respons memiliki status 200 dan struktur JSON yang diharapkan
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Add donasi successful',
            ]);

        // Opsional: Menghapus file dummy setelah pengujian
        Storage::disk('public')->delete($file->hashName());
    }

    /** @test */
    public function user_cannot_store_rekap_donasi_with_invalid_data()
    {
        // Authentikasi sebagai admin
        $this->actingAs($this->admin, 'sanctum');

        // Mengirim permintaan POST JSON dengan data yang tidak valid
        $response = $this->postJson('/api/admin/manajemen/rekap-donasi', [
            'nominal' => '', // nominal tidak boleh kosong
            'deskripsi' => '', // deskripsi tidak boleh kosong
            'file' => '', // file bisa kosong
            'users_id' => '', // Ini harus diisi dengan id pengguna yang valid
        ]);

        // Log isi respons untuk debugging jika diperlukan
        Log::info($response->getContent());

        // Memastikan respons memiliki status 422 (Unprocessable Entity) dan ada error validasi yang diharapkan
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nominal', 'deskripsi', 'users_id']);
    }

    /** @test */
    public function user_can_edit_rekap_donasi()
    {
        // Authentikasi sebagai admin
        $this->actingAs($this->admin, 'sanctum');

        // Membuat data BuktiDonasi untuk diuji
        $donasi = BuktiDonasi::factory()->create();

        // Mengirim permintaan GET JSON ke edit method
        $response = $this->getJson('/api/admin/manajemen/rekap-donasi/edit/' . $donasi->id);

        // Log isi respons untuk debugging jika diperlukan
        Log::info($response->getContent());

        // Memastikan respons memiliki status 200 dan struktur JSON yang diharapkan
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Get donasi successful',
                // Pastikan data donasi yang dikembalikan sesuai dengan yang diharapkan
                'donasi' => $donasi->toArray(),
            ]);
    }

    /** @test */
    public function user_can_update_donasi()
    {
        // Authentikasi sebagai admin
        $this->actingAs($this->admin, 'sanctum');

        // Membuat data BuktiDonasi untuk diuji
        $donasi = BuktiDonasi::factory()->create();

        // Persiapan file untuk di-upload (contoh menggunakan file dummy)
        Storage::fake('public');
        $file = UploadedFile::fake()->image('donasi.jpg');

        // Mengirim permintaan PUT JSON ke update method
        $response = $this->putJson('/api/admin/manajemen/rekap-donasi/update/' . $donasi->id, [
            'nominal' => '5000',
            'deskripsi' => 'Test Deskripsi',
            'file' => $file,
            'users_id' => $this->admin->id, // id pengguna yang terautentikasi
        ]);

        // Log isi respons untuk debugging jika diperlukan
        Log::info($response->getContent());

        // Memastikan respons memiliki status 200 dan struktur JSON yang diharapkan
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Update donasi successful',
            ]);

        // Opsional: Menghapus file dummy setelah pengujian
        Storage::disk('public')->delete($file->hashName());
    }

    /** @test */
    public function user_cannot_update_donasi()
    {
        // Authentikasi sebagai admin
        $this->actingAs($this->admin, 'sanctum');

        // Membuat data BuktiDonasi untuk diuji
        $donasi = BuktiDonasi::factory()->create();

        $response = $this->putJson('/api/admin/manajemen/rekap-donasi/update/' . $donasi->id, [
            'nominal' => '', // nominal tidak boleh kosong
            'deskripsi' => '',
            'file' => '',
            'users_id' => $this->admin->id, // Ini harus diisi dengan id pengguna yang valid
        ]);

        Log::info($response->getContent());
 
         $response->assertStatus(422)
             ->assertJsonValidationErrors(['nominal', 'deskripsi']);
     }

    /** @test */
    public function user_can_destroy_donasi()
    {
        // Authentikasi sebagai admin
        $this->actingAs($this->admin, 'sanctum');

        // Membuat data BuktiDonasi untuk diuji
        $donasi = BuktiDonasi::factory()->create();

        // Simulasikan penghapusan dengan permintaan DELETE JSON ke destroy method
        $response = $this->deleteJson('/api/admin/manajemen/rekap-donasi/delete/' . $donasi->id);

        // Log isi respons untuk debugging jika diperlukan
        Log::info($response->getContent());

        // Memastikan respons memiliki status 200 dan struktur JSON yang diharapkan
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Donasi has been removed',
            ]);
    }
}
