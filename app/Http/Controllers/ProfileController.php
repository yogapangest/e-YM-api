<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Memastikan hanya pengguna yang login dapat melihat profil mereka sendiri
        if ($id != Auth::user()->id) {
            return redirect()->back();
        }

        // Mengirim data pengguna ke view
        $user = Auth::user();

        return view('page.manajemen_profile.index', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'alamat' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'password' => ['nullable', 'string', 'min:8', 'confirmed', Password::defaults()],
            'password_confirmation' => 'nullable|min:8',
        ]);

        // Persiapkan data untuk diupdate
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'alamat' => $validated['alamat'],
            'telephone' => $validated['telephone'],
        ];

        // Pengecekan apakah ada input password
        if (!empty($request->input('password'))) {
            // Hash password
            $updateData['password'] = Hash::make($request->input('password'));
        }

        // Update data user
        $user->update($updateData);

        // Menampilkan pesan sukses menggunakan alert
        // Alert::success('Success', 'Profil Berhasil Diupdate');

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
