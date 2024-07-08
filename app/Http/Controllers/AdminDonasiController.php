<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminDonasiController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        // Mencari user berdasarkan user_id, jika tidak ditemukan akan menghasilkan 404
        $user = User::findOrFail($user_id);

        // Mengambil semua data donasi yang sesuai dengan user_id
        $donasi = Donasi::where('user_id', $user_id)->get();

        // Menyusun data untuk dikirim ke view
        $data = [
            'donasi' => $donasi,
            'user' => $user,
        ];

        // Mengirim data ke view
        return view('page.manajemen_donasi.show', $data);
    }

    public function createform($user_id)
    {
        // Mengambil user berdasarkan id
        $user = User::findOrFail($user_id);

        // Mengirim data user_id ke view
        return view('page.manajemen_donasi.formadmin', compact('user_id'));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function storeform(Request $request, $user_id)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('file')) {
            // Menggunakan waktu sekarang untuk membuat nama file unik
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/donasis', $fileName);
        }

        // Membuat entri baru pada tabel Donasi
        Donasi::create([
            'user_id' => $user_id,
            'deskripsi' => $validated['deskripsi'],
            'nominal' => $validated['nominal'],
            'file' => $fileName,
        ]);

        return redirect()->route('form.show.donasi_admin', $user_id)->with('toast_success', 'Data dokumen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editform(string $id)
    {
        $data = [
            'donasi' => Donasi::findOrFail($id),
        ];
        return view('page.manajemen_donasi.editadmin', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateform(Request $request, string $id)
    {
        
        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        
        $donasi = Donasi::findOrFail($id); 
        
        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/donasis', $fileName);
            $validated['file'] = $fileName;
        }
        
        $donasi->update($validated); 
        $user_id = $donasi->user->id;
        
        return redirect()->route('form.show.donasi_admin',['user_id' => $user_id])->with('toast_success', 'Data dokumen berhasil diperbarui.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donasi = Donasi::findOrFail($id); // Temukan donasi berdasarkan ID

        // Ambil user_id sebelum menghapus donasi
        $userId = $donasi->user_id;

        // Hapus file terkait jika ada
        if ($donasi->file) {
            Storage::disk('public')->delete('donasis/' . $donasi->file);
        }

        // Hapus donasi dari database
        $donasi->delete();

        // Redirect ke halaman yang menampilkan donasi sesuai dengan user_id
        return redirect()->route('form.show.donasi_admin', ['user_id' => $userId])->with('toast_success', 'Data dokumen berhasil dihapus.');
    }

}
