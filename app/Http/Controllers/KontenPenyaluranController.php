<?php

namespace App\Http\Controllers;

use App\Models\KontenPenyaluran;
use Illuminate\Http\Request;

class KontenPenyaluranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['KontenPenyaluran']=KontenPenyaluran::all();
        return view('page.konten_penyaluran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.konten_penyaluran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        'keterangan' => 'nullable',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $input = $request->all();

    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan foto menggunakan filesystem 'public'
        $image->storeAs('public/images', $imageName);

        // Simpan path foto ke dalam database
        $input['foto'] = 'images/' . $imageName;
    }

        KontenPenyaluran::create($input);

        return redirect()->route('index.view.penyaluran')
            ->with('toast_success', 'Konten berhasil ditambahkan');
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
        $data = [
            'KontenPenyaluran' => KontenPenyaluran::findOrFail($id),
        ];
        return view('page.konten_penyaluran.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nama' => 'required',
        'keterangan' => 'nullable',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $input = $request->all();

    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan foto menggunakan filesystem 'public'
        $image->storeAs('public/images', $imageName);

        // Simpan path foto ke dalam database
        $input['foto'] = 'images/' . $imageName;
    }

        $konten = KontenPenyaluran::findOrFail($id);
        $konten->update($input);

        return redirect()->route('index.view.penyaluran')
            ->with('toast_success', 'Konten berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $konten = KontenPenyaluran::findOrFail($id);
        $konten->delete();

        return redirect()->route('index.view.penyaluran')
            ->with('toast_success', 'Konten berhasil dihapus');
    }
}
