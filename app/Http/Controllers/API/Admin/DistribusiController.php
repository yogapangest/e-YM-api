<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\Program;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class DistribusiController extends Controller
{
    public function index()
    {
        try {
            $distribusis = Distribusi::with('Program')->get();
            $url = '/admin/distribusi';

            return response()->json([
                'status' => 'succes',
                'message' => 'Get data distribusi successfull',
                'distribusi' => $distribusis,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to get Distribusi: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get distribusi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tanggal' => 'required|nullable|date',
                'tempat' => 'required|string',
                'penerima_manfaat' => 'required|string',
                'anggaran' => 'required|string|max:128',
                // 'pengeluaran' => 'required|string|max:128',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'programs_id' => 'required|exists:programs,id',
            ]);

            // Hitung nilai untuk field "sisa"
            $anggaran = floatval($validatedData['anggaran']);
            $pengeluaran = 0;
            $sisa = $anggaran - $pengeluaran;

            // Tambahkan nilai "sisa" ke dalam data yang divalidasi
            $validatedData['sisa'] = $sisa;
            $validatedData['pengeluaran'] = $pengeluaran;

            if ($request->hasFile('file')) {
                $files = $request->file('file');
                if ($files->isValid()) {
                    $fileName = uniqid('distribusi_') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('file/distribusi'), $fileName);
                    $validatedData['file'] = $fileName;
                }
            }

            $distribusis = Distribusi::create($validatedData);
            $url = 'apps/admin/distribusi';

            return response()->json([
                'status' => 'success',
                'message' => 'Add distribusi successful',
                'distribusi' => $distribusis,
                'url' => $url,
            ], 200);
        } catch (ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to add program: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add distribusi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $distribusis = Distribusi::with('Program')->findOrFail($id);
            $url = sprintf('/admin/distribusi/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get distribusi successfull',
                'distribusi' => $distribusis,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get distribusi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            $distribusi = Distribusi::findOrFail($id);

            $validatedData = $request->validate([
                'tanggal' => 'required|nullable|date',
                'tempat' => 'required|string',
                'penerima_manfaat' => 'required|string',
                'anggaran' => 'required|numeric',
                // 'pengeluaran' => 'required|numeric',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'programs_id' => 'required|exists:programs,id',
            ]);

            // Hitung nilai untuk field "sisa"
            $validatedData['sisa'] = $validatedData['anggaran'] - $distribusi->pengeluaran;

            if ($request->hasFile('file')) {
                if ($distribusi->file) {
                    File::delete(public_path('file/distribusi/' . $distribusi->file));
                }

                $files = $request->file('file');
                $fileName = uniqid('distribusi_') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('file/distribusi'), $fileName);
                $validatedData['file'] = $fileName;
            }

            $distribusi->update($validatedData);
            $url = '/admin/distribusi';

            return response()->json([
                'status' => 'success',
                'message' => 'Update distribusi successful',
                'distribusi' => $distribusi,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update distribusi',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $distribusis = Distribusi::findOrFail($id);

            if ($distribusis->file) {
                File::delete(public_path('file/distribusi/' . $distribusis->file));
            }

            $distribusis->delete();
            $url = '/admin/distribusi';

            return response()->json([
                'status' => 'success',
                'message' => 'Distribusi has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove distribusi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}