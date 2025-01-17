<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\User;
use App\Models\BuktiDonasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class RekapDonasiController extends Controller
{
    public function index($id)
    {
        try {

            // Ambil data donasi berdasarkan users_id
            $donasis = BuktiDonasi::where('users_id', $id)->get();

            // dd($donasis);
            $url = '/admin/donasi';

            return response()->json([
                'status' => 'success',
                'message' => 'Get data donasi successful',
                'donasi' => $donasis,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nominal' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,jpg,png|max:2048',
                'users_id' => 'required|integer|exists:users,id',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if ($file->isValid()) {
                    $fileName = uniqid('donasi_') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('file/donasi'), $fileName);
                    $validatedData['file'] = $fileName;
                }
            }

            $donasi = BuktiDonasi::create($validatedData);
            $url = '/admin/donasi';



            return response()->json([
                'status' => 'success',
                'message' => 'Add donasi successful',
                'donasi' => $donasi,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk mengambil data donasi berdasarkan ID
    public function edit($id)
    {
        try {
            $donasi = BuktiDonasi::findOrFail($id);
            $url = sprintf('/admin/donasi/view/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get donasi successful',
                'donasi' => $donasi,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk memperbarui data donasi
    public function update(Request $request, $id)
    {
        try {
            $donasi = BuktiDonasi::findOrFail($id);

            $validatedData = $request->validate([
                'nominal' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,jpg,png|max:2048',
            ]);

            if ($request->hasFile('file')) {
                if ($donasi->file) {
                    File::delete(public_path('file/donasi/' . $donasi->file));
                }

                $file = $request->file('file');
                $fileName = uniqid('donasi_') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('file/donasi'), $fileName);
                $validatedData['file'] = $fileName;
            } else {
                $validatedData['file'] = $donasi->file;
            }
            $userId = $donasi->users_id;
            $donasi->update($validatedData);
            $url = sprintf('/apps/donasi/view/%d', $userId);


            return response()->json([
                'status' => 'success',
                'message' => 'Update donasi successful',
                'donasi' => $donasi,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk menghapus data donasi
    public function destroy($id)
    {
        try {
            $donasi = BuktiDonasi::findOrFail($id);

            if ($donasi->file) {
                File::delete(public_path('file/donasi/' . $donasi->file));
            }

            $donasi->delete();
            $url = '/admin/donasi';

            return response()->json([
                'status' => 'success',
                'message' => 'Donasi has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}