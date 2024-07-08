<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil user_id dari user yang sedang login
        $userId = Auth::user()->id;

        // Dapatkan donasi hanya untuk user yang sedang login
        $data['Donasi'] = Donasi::where('user_id', $userId)->get();

        return view('page.manajemen_donasi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.manajemen_donasi.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Memvalidasi input dari request
        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        // Mengecek apakah file di-upload dan menyimpannya
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            // Menggunakan nama unik untuk file yang di-upload
            $fileName = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/donasis', $fileName);
            $validated['file'] = $fileName;
        }

        // Mendapatkan user_id dari user yang sedang login
        $validated['user_id'] = Auth::id();

        // Membuat entri baru pada tabel Donasi
        Donasi::create($validated);

        // Mengarahkan ke halaman dashboard dengan pesan sukses
        return redirect()->route('form.index.donasi')->with('toast_success', 'Data dokumen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'donasi' => Donasi::findOrFail($id),
        ];
        return view('page.manajemen_donasi.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $donasi = Donasi::findOrFail($id);

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/donasis', $fileName);
            $validated['file'] = $fileName;
        }

        $donasi->update($validated);

        return redirect()->route('form.index.donasi')->with('toast_success', 'Data dokumen berhasil diperbarui.');
    }

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
        return view('page.manajemen_donasi.formadmin', compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeform(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/donasis', $fileName);
        }

        // Membuat entri baru pada tabel Donasi
        Donasi::create([
            'user_id' => $validated['user_id'],
            'deskripsi' => $validated['deskripsi'],
            'nominal' => $validated['nominal'],
            'file' => $fileName,
        ]);

        return redirect()->route('form.show.donasi', $request->user_id)->with('toast_success', 'Data dokumen berhasil ditambahkan.');
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
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        $donasi = Donasi::findOrFail($id);

        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/donasis', $fileName);
            $validated['file'] = $fileName;
        }

        $donasi->update($validated);
        $user_id = $donasi->user->id;

        return redirect()->route('form.show.donasi',['user_id' => $user_id])->with('toast_success', 'Data dokumen berhasil diperbarui.');
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
        return redirect()->route('form.show.donasi', ['user_id' => $userId])->with('toast_success', 'Data dokumen berhasil dihapus.');
    }


}