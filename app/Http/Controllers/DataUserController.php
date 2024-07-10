<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil peran "guest"
        $guestRole = Role::where('name', 'guest')->first();

        // Jika peran "guest" tidak ditemukan, kembalikan tampilan kosong
        if (!$guestRole) {
            return view('page.manajemen_data_user.index', ['users' => []]);
        }

        // Mengambil semua pengguna yang memiliki peran "guest"
        $users = $guestRole->users;

        // Menyiapkan data untuk dikirim ke tampilan
        $data = [
            'users' => $users,
        ];

        // Mengirim data ke tampilan
        return view('page.manajemen_data_user.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.manajemen_data_user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'alamat' => 'required',
            'telephone' => 'required|digits_between:8,12',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create the user with the validated data
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'alamat' => $request->alamat,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the 'Guest' role to the newly created user
        $guestRole = Role::where('name', 'Guest')->first();
        if ($guestRole) {
            $user->assignRole($guestRole);
        }

        // Redirect the user to the dashboard with a success message
        return redirect()->route('index.view.datauser')->with('toast_success', 'User Berhasil Ditambahkan');
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
            'dataUser' => User::findOrFail($id),
        ];
        return view('page.manajemen_data_user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'alamat' => 'required',
            'telephone' => 'required|digits_between:8,12',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->alamat = $request->alamat;
        $user->telephone = $request->telephone;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('index.view.datauser')->with('toast_success', 'User Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('index.view.datauser')->with('toast_success', 'Data Barang Berhasil Dihapus');
    }
}
