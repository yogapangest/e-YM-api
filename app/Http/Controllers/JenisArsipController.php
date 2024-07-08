<?php

namespace App\Http\Controllers;

use App\Models\JenisArsip;
use Illuminate\Http\Request;

class JenisArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jenisArsip = JenisArsip::orderBy('created_at', 'DESC')->get();
        // return view('page.manajemen_jenis_arsip.index', compact('jenisArsip'));
        $data['jenisArsip']=JenisArsip::all();
        return view('page.manajemen_jenis_arsip.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.manajemen_jenis_arsip.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        JenisArsip::create([
            'nama' => $validated['nama'],
            'keterangan' => $validated['keterangan'],
        ]);


        return redirect()->route('index.view')->with('toast_success', 'Jenis Arsip Berhasil Ditambahkan');
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
            'jenisArsip' => JenisArsip::findOrFail($id),
        ];
        return view('page.manajemen_jenis_arsip.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jenisArsip = JenisArsip::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        JenisArsip::where('id', $jenisArsip->id)->update([
            'nama' => $validated['nama'],
            'keterangan' => $validated['keterangan'],
        ]);


        return redirect()->route('index.view')->with('toast_success', 'Jenis Arsip Berhasil Diubah');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisArsip = JenisArsip::findOrFail($id);
        $jenisArsip->delete();

        return redirect()->route('index.view')->with('toast_success', 'Jenis Arsip Berhasil Dihapus');

    }
}