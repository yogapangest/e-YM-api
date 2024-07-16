<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\JenisArsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class JenisArsipController extends Controller
{
    public function index()
    {
        try {
            $jenisarsips = JenisArsip::all();
            // $url = '/apps/admin/jenisarsip';

            return response()->json([
                'status' => 'success',
                'message' => 'Get data jenisarsip successfull',
                'jenisarsip' => $jenisarsips,
                // 'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get jenisarsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_arsip' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            $jenisarsips = JenisArsip::create($validatedData);
            $url = '/apps/admin/jenisarsip';

            return response()->json([
                'status' => 'success',
                'message' => 'Add jenisarsip successful',
                'jenisarsip' => $jenisarsips,
                'url' => $url,
            ]);
        } catch (ValidationException $e) {
            Log::error('ed to add jenis arsip: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'ed to add jenis arsip',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add jenisarsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        try {
            $jenisarsips = JenisArsip::findOrFail($id);

            $url = sprintf('/admin/jenisarsip/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get jenisarsip successful',
                'jenisarsip' => $jenisarsips,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get jenisarsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jenisarsips = JenisArsip::findOrFail($id);

            $validatedData = $request->validate([
                'nama_arsip' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            $jenisarsips->update($validatedData);
            $url = '/apps/jenis-arsip/view';

            return response()->json([
                'status' => 'success',
                'message' => 'Update jenisarsip successful',
                'jenisarsip' => $jenisarsips,
                'url' => $url,
            ]);
        } catch (ValidationException $e) {
            Log::error('Failed to update jenis arsip: ' . $e->getMessage());
            return response()->json([
                'status' => 'error', 
                'message' => 'Failed to update jenis arsip', 
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update jenisarsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $jenisarsips = JenisArsip::findOrFail($id);

            $jenisarsips->delete();
            $url = '/apps/admin/jenisarsip';

            return response()->json([
                'status' => 'success',
                'message' => 'jenisarsip has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove jenisarsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
