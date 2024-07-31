<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class DistribusiController extends Controller
{
    public function index(Request $request)
{
    try {
        $query = $request->input('q');

        // Mulai query distribusi
        $distribusis = Distribusi::with('program');

        // Log query untuk debugging
        Log::info('Search query: ' . $query);

        // Tambahkan logika pencarian jika ada parameter q
        if ($query) {
            $queryDate = null;
            $queryMonth = null;
            $queryYear = null;

            // Attempt to parse query as a date
            try {
                $queryDate = Carbon::createFromFormat('d F Y', $query)->format('Y-m-d');
                Log::info('Parsed date: ' . $queryDate);
            } catch (\Exception $e) {
                Log::info('Failed to parse date: ' . $e->getMessage());
            }

            // Attempt to parse query as a month
            try {
                $queryMonth = Carbon::createFromFormat('F Y', $query)->format('Y-m');
                Log::info('Parsed month: ' . $queryMonth);
            } catch (\Exception $e) {
                Log::info('Failed to parse month: ' . $e->getMessage());
            }

            // Attempt to parse query as a year
            try {
                $queryYear = Carbon::createFromFormat('Y', $query)->format('Y');
                Log::info('Parsed year: ' . $queryYear);
            } catch (\Exception $e) {
                Log::info('Failed to parse year: ' . $e->getMessage());
            }

            // Apply search criteria
            $distribusis = $distribusis->where(function($q) use ($query, $queryDate, $queryMonth, $queryYear) {
                $q->where('tempat', 'LIKE', '%' . $query . '%')
                  ->orWhere('penerima_manfaat', 'LIKE', '%' . $query . '%')
                  ->orWhere('anggaran', 'LIKE', '%' . $query . '%')
                  ->orWhere('pengeluaran', 'LIKE', '%' . $query . '%')
                  ->orWhere('sisa', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('program', function($q) use ($query) {
                      $q->where('nama_program', 'LIKE', '%' . $query . '%');
                  });

                if ($queryDate) {
                    $q->orWhere(DB::raw("DATE_FORMAT(tanggal, '%Y-%m-%d')"), 'LIKE', '%' . $queryDate . '%');
                }

                if ($queryMonth) {
                    $q->orWhere(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"), 'LIKE', '%' . $queryMonth . '%');
                }

                if ($queryYear) {
                    $q->orWhere(DB::raw("DATE_FORMAT(tanggal, '%Y')"), 'LIKE', '%' . $queryYear . '%');
                }
            });
        }

        // Dapatkan hasil query
        $distribusis = $distribusis->get();
        $url = '/admin/distribusi';

        return response()->json([
            'status' => 'success',
            'message' => 'Get data distribusi successful',
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
                'message' => 'Distribusi Berhasil Dihapus',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal Untuk Menghapus Data Distribusi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}