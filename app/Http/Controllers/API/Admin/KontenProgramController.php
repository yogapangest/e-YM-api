<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\KontenProgram;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class KontenProgramController extends Controller
{
    public function index()
    {
        try {
            $kontenprograms = KontenProgram::all();
            $url = '/admin/kontenprogram';

            return response()->json([
                'status' => 'succes',
                'message' => 'Get data konten program successfull',
                'kontenprogram' => $kontenprograms,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get konten program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_kontenprogram' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jpg,png|max:2048',

            ]);
            if ($request->hasFile('foto')) {
                $files = $request->file('foto');
                if ($files->isValid()) {
                    $fileName = uniqid('kontenprogram_') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('file/kontenprogram'), $fileName);
                    $validatedData['foto'] = $fileName;
                }
            }
            $kontenprograms = KontenProgram::create($validatedData);
            $url = '/admin/kontenprogram';

            return response()->json([
                'status' => 'success',
                'message' => 'Add konten program seccessfull',
                'kontenprogram' => $kontenprograms,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add konten program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $kontenprograms = KontenProgram::findOrFail($id);

            $url = sprintf('/admin/kontenprogram/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get konten program successful',
                'kontenprogram' => $kontenprograms,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get konten program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $kontenprograms = KontenProgram::findOrfail($id);

            $validatedData = $request->validate([
                'nama_kontenprogram' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jpg,png|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($kontenprograms->file) {
                    File::delete(public_path('file/kontenprogram' . $kontenprograms->file));
                }

                $files = $request->file('foto');
                $FileName = uniqid('kontenprogram_') . '.' . $file->getClientOriginalExtension();
                $files->move(public_path('file/kontenprogram'), $FileName);
                $validatedData['foto'] = $FileName;
            } else {
                $validatedData['foto'] = $donasis->file;
            }
            $kontenprograms->update($validatedData);
            $url = '/admin/kontenprogram';

            return response()->json([
                'status' => 'success',
                'message' => 'Update konten program seccesfull',
                'kontenprogram' => $kontenprograms,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update konten program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $kontenprograms = KontenProgram::findOrFail($id);

            if ($kontenprograms->file) {
                File::delete(public_path('file/kontenprogram/' . $kontenprograms->file));
            }

            $kontenprograms->delete();
            $url = '/admin/kontenprogram';
            
            return response()->json([
                'status' => 'seccess',
                'message' => 'Konten program has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove konten program',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
