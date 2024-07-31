<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\KontenPenyaluran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class KontenPenyaluranController extends Controller
{
    public function index()
    {
        try {
            $kontenpenyalurans = KontenPenyaluran::all();
            $url = '/admin/kontenpenyaluran';

            return response()->json([
                'status' => 'succes',
                'message' => 'Get data konten penyaluran successfull',
                'kontenpenyaluran' => $kontenpenyalurans,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get konten penyaluran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_penyaluran' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jpg,png|max:2048',

            ]);
            if ($request->hasFile('foto')) {
                $files = $request->file('foto');
                if ($files->isValid()) {
                    $fileName = uniqid('kontenpenyaluran_') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('file/kontenpenyaluran'), $fileName);
                    $validatedData['foto'] = $fileName;
                }
            }
            $kontenpenyalurans = KontenPenyaluran::create($validatedData);
            $url = '/admin/kontenpenyaluran';

            return response()->json([
                'status' => 'success',
                'message' => 'Add konten penyaluran seccessfull',
                'kontenpenyaluran' => $kontenpenyalurans,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add konten penyaluran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $kontenpenyalurans = KontenPenyaluran::findOrFail($id);

            $url = sprintf('/admin/kontenpenyaluran/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get konten penyaluran successful',
                'kontenpenyaluran' => $kontenpenyalurans,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get konten penyaluran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $kontenpenyalurans = KontenPenyaluran::findOrfail($id);

            $validatedData = $request->validate([
                'nama_penyaluran' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jpg,png|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($kontenpenyalurans->file) {
                    File::delete(public_path('file/kontenpenyaluran' . $kontenpenyalurans->file));
                }

                $files = $request->file('foto');
                $FileName = uniqid('kontenpenyaluran_') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('file/kontenpenyaluran'), $FileName);
                $validatedData['foto'] = $FileName;
            }
            $kontenpenyalurans->update($validatedData);
            $url = '/apps/konten_penyaluran/view';

            return response()->json([
                'status' => 'success',
                'message' => 'Update konten penyaluran seccesfull',
                'kontenpenyaluran' => $kontenpenyalurans,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update kontenpenyaluran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $kontenpenyalurans = KontenPenyaluran::findOrFail($id);

            if ($kontenpenyalurans->file) {
                File::delete(public_path('file/kontenpenyaluran/' . $kontenpenyalurans->file));
            }

            $kontenpenyalurans->delete();
            $url = '/admin/kontenpenyaluran';

            return response()->json([
                'status' => 'success',
                'message' => 'Konten Penyaluran has been removed',
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove konten penyaluran',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}