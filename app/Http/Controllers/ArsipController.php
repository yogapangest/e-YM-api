<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\JenisArsip;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $arsips = Arsip::all();
        // $program = Arsip::with('program')->paginate(); // Mengambil semua data Arsip beserta data Program terkait
        // $jenisArsip = Arsip::with('jenisArsip')->paginate(); // Mengambil semua data Arsip beserta data jenis arsip terkait

        $arsips = Arsip::with(['program', 'jenisArsip'])->paginate();

        return view('page.manajemen_arsip.index', compact('arsips'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $program=Program::all();
        $jenisArsip=JenisArsip::all();
        return view('page.manajemen_arsip.create', compact('program','jenisArsip'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'programs_id' => 'required|exists:programs,id', // Validasi bahwa program_id harus ada dalam tabel programs
            'jenisArsip_id' => 'required|exists:jenis_arsips,id', // Validasi bahwa program_id harus ada dalam tabel programs
            'file' => 'file|mimes:pdf,docx|max:2048', // Contoh validasi untuk file PDF dan DOCX dengan ukuran maksimal 2MB
        ]);

        $fileName = null; // Inisialisasi $fileName agar tidak terjadi error pada saat pengecekan

        if ($request->hasFile('file')) {
        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('arsips', $fileName, 'public');
        }

         $program = Program::findOrFail($request->programs_id);
         $jenisArsip = JenisArsip::findOrFail($request->jenisArsip_id);

        Arsip::create([
            // 'nama' => $program->nama, // Mengisi field nama di Arsip dengan nama dari Program terkait
            'programs_id' => $request->programs_id,
            'nama' => $program->nama, // Mengambil nama Program terkait
            // 'jenis_arsip' => $request->jenis_arsip,
            'jenisArsip_id' => $request->jenisArsip_id,
            'nama' => $jenisArsip->nama,
            'file' => $fileName, // Simpan nama file ke dalam database
            // 'program_id' => $program->id, // Simpan ID Program terkait dengan Arsip
        ]);

        return redirect()->route('index.view.arsip')
        ->with('toast_success', 'Arsip berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $arsip = Arsip::with('program','jenisArsip')->findOrFail($id);
        $programs = Program::all();
        $jenisArsip = JenisArsip::all();
        // dd($id);

        return view('page.manajemen_arsip.edit', compact('arsip', 'programs', 'jenisArsip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        // 'programs_id' => 'sometimes|exists:programs,id',
        // 'jenisArsip_id' => 'sometimes|exists:jenis_arsips,id',
        // 'file' => 'file|mimes:pdf,docx|max:2048',
        // ]);
        $request->validate([
            'programs_id' => 'required',
            'jenisArsip_id' => 'required',
            'file' => 'file|mimes:pdf,docx|max:2048',
        ], [
            'programs_id.required' => 'The program field is required.',
            'jenisArsip_id.required' => 'The jenis arsip field is required.',
        ]);


        $arsip = Arsip::findOrFail($id);
        $program = Program::findOrFail($request->programs_id);
        $jenisArsip = JenisArsip::findOrFail($request->jenisArsip_id);
        $fileName = $arsip->file; // Simpan nama file lama jika tidak ada file baru diunggah

        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('arsips', $fileName, 'public');
        }
        // dd($request);


        $arsip->update([
            'programs_id' => $program->id,
            'jenisArsip_id' => $jenisArsip->id,
            'nama' => $program->nama,
            'jenisArsip' => $jenisArsip->nama,
            'file' => $fileName,
        ]);

        return redirect()->route('index.view.arsip')
            ->with('toast_success', 'Arsip berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arsip = Arsip::findOrFail($id); // Temukan program berdasarkan ID

    // Hapus file terkait jika ada
    if ($arsip->file) {
        Storage::disk('public')->delete('arsips/' . $arsip->file);
    }

    // Hapus program dari database
    $arsip->delete();

    return redirect()->route('index.view.arsip')->with('toast_success', 'Data dokumen berhasil dihapus.');
    }
}