<?php

namespace App\Http\Controllers\API\User;

use Exception;
use App\Models\User;
use App\Models\BuktiDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class FormDonasiController extends Controller
{
    public function index($id_user)
    {
        try {
            $user = User::findOrFail($id_user);

            $donasis = BuktiDonasi::where('users_id', $id_user)->get();
            $url = '/admin/donasi';

            return response()->json([
                'status' => 'success',
                'message' => 'Get data donasi successful',
                'donasi' => $donasis,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to get donasi: ' . $e->getMessage());

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

            ]);

            $validatedData['users_id'] = $request->user()->id;

            if ($request->hasFile('file')) {
                $files = $request->file('file');
                if ($files->isValid()) {
                    $fileName = uniqid('donasi_') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('file/donasi'), $fileName);
                    $validatedData['file'] = $fileName;
                }
            }
            $donasis = BuktiDonasi::create($validatedData);
            $url = '/admin/donasi';

            return response()->json([
                'status' => 'success',
                'message' => 'Add donasi seccessfull',
                'donasi' => $donasis,
                'url' => $url,
            ]);
        } catch (ValidationException $e) {
            Log::error('Failed to add donasi: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add donasi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $donasis = BuktiDonasi::findOrFail($id);

            $url = sprintf('/admin/donasi/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get donasi successful',
                'donasi' => $donasis,
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

    public function update(Request $request, $id)
    {
        try {
            $donasis = BuktiDonasi::findOrfail($id);

            $validatedData = $request->validate([
                'nominal' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,jpg,png|max:2048',
            ]);

            if ($request->hasFile('file')) {
                if ($donasis->file) {
                    File::delete(public_path('file/donasi' . $donasis->file));
                }

                $files = $request->file('file');
                $FileName = uniqid('donasi_') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('file/donasi'), $FileName);
                $validatedData['file'] = $FileName;
            } else {
                $validatedData['file'] = $donasis->file;
            }

            $donasis->update($validatedData);
            $url = '/admin/donasi';

            return response()->json([
                'status' => 'success',
                'message' => 'Update donasi seccesfull',
                'donasi' => $donasis,
                'url' => $url,
            ]);
        } catch (ValidationException $e) {
            Log::error('Failed to update donasi: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update donasi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $donasis = BuktiDonasi::findOrFail($id);

            if ($donasis->file) {
                File::delete(public_path('file/donasi/' . $donasis->file));
            }

            $donasis->delete();
            $url = '/admin/donasi';

            return response()->json([
                'status' => 'seccess',
                'message' => 'donasi has been removed',
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
