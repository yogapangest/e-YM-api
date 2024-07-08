<?php

namespace App\Http\Controllers;

use App\Models\DataDonasi;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DataDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data['dataDonasi']=DataDonasi::all();
    //     return view('page.manajemen_data_donasi.index', $data);
    // }
    //     public function index()
    // {
    //     // Mengambil semua data pengguna (User)
    //     $users = User::all();

    //     // Mengambil semua data donasi beserta relasi user
    //     $dataDonasi = DataDonasi::with('user')->get();

    //     return view('page.manajemen_data_donasi.index', compact('users', 'dataDonasi'));
    // }

        public function index()
        {
            // Mengambil data pengguna (User) berdasarkan ID
            $userId = auth()->user()->id;
            $user = User::find($userId);

            // Mengambil semua data donasi berdasarkan user
            $dataDonasi = DataDonasi::where('user_id', $userId)->get();


            return view('page.manajemen_data_donasi.index', compact('user', 'dataDonasi'));
        }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Mengambil semua data pengguna (User)
        // return view('data_donasi.create', compact('users'));
        return view('page.manajemen_data_donasi.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'alamat' => 'required',
    //         'telephone' => 'required',
    //         'email' => 'required|email|unique:data_donasis,email',
    //     ]);

    //     DataDonasi::create($request->all());

    //     return redirect()->route('index.view.datadonasi')
    //         ->with('toast_success', 'Data donasi berhasil ditambahkan');
    // }

     public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Validasi user_id harus ada di tabel users
            // 'jumlah_donasi' => 'required|numeric|min:1', // Validasi jumlah_donasi harus angka dan minimal 1
            // Tambahkan validasi untuk field lain jika diperlukan
        ]);

        DataDonasi::create($request->all()); // Simpan data donasi baru
        return redirect()->route('index.view.datadonasi')
                         ->with('success', 'Data donasi berhasil ditambahkan');
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
        // $donasi = DataDonasi::findOrFail($id);
         $data = [
            'dataDonasi' => DataDonasi::findOrFail($id),
        ];
        return view('page.manajemen_data_donasi.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telephone' => 'required',
            'email' => 'required|email|unique:data_donasis,email,' . $id,
        ]);

            $donasi = DataDonasi::findOrFail($id);
            $donasi->update($request->all());

            return redirect()->route('index.view.datadonasi')
                ->with('toast_success', 'Data Donasi Berhasil Diperbarui');
}
    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $dataDonasi = DataDonasi::findOrFail($id);
    //     $dataDonasi->delete();

    //     return redirect()->route('index.view.datadonasi')->with('toast_success', 'Data Donasi Berhasil Dihapus');
    // }
    public function destroy($id)
    {
        // Menghapus data donasi berdasarkan ID
        $dataDonasi = DataDonasi::find($id);
        $dataDonasi->delete();

        // Menghapus data pengguna (User) terkait jika perlu
        $userId = $dataDonasi->user_id;
        User::find($userId)->delete();

        return redirect()->route('nama_rute_yang_diinginkan')
                        ->with('success', 'Data donasi berhasil dihapus');
    }

}