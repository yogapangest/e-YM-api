<?php

namespace App\Http\Controllers;

use App\Models\KontenProgram;
use Illuminate\Http\Request;

class KontenProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['KontenProgram']=KontenProgram::all();
        return view('page.konten_program.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.konten_program.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $input = $request->all();

    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan foto menggunakan filesystem 'public'
        $image->storeAs('public/images_program', $imageName);

        // Simpan path foto ke dalam database
        $input['foto'] = 'images_program/' . $imageName;
    }

        KontenProgram::create($input);

        return redirect()->route('index.view.kprogram')
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
            'KontenProgram' => KontenProgram::findOrFail($id),
        ];
        return view('page.konten_program.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nama' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $input = $request->all();

    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan foto menggunakan filesystem 'public'
        $image->storeAs('public/images_program', $imageName);

        // Simpan path foto ke dalam database
        $input['foto'] = 'images_program/' . $imageName;
    }

        $kontenProgram = KontenProgram::findOrFail($id);
        $kontenProgram->update($input);

        return redirect()->route('index.view.kprogram')
            ->with('toast_success', 'Konten berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kontenProgram = KontenProgram::findOrFail($id);
        $kontenProgram->delete();

        return redirect()->route('index.view.kprogram')
            ->with('toast_success', 'Konten berhasil dihapus');
    }
}
