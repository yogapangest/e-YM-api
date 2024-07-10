<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\Arsip;
use App\Models\Program;
use App\Models\JenisArsip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ArsipController extends Controller
{
    public function index()
    {
        try {
            $arsips = Arsip::with('Program','JenisArsip')->get();
            $url = '/admin/arsip';

            return response()->json([
                'status' => 'succes',
                'message' => 'Get data arsip successfull',
                'arsip' => $arsips,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get arsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'programs_id' => 'required|exists:programs,id',
                'jenisarsips_id' => 'required|exists:jenis_arsips,id',

            ]);

            if ($request->hasFile('file')) {
                $files = $request->file('file');
                if ($files->isValid()) {
                    $fileName = uniqid('arsip_') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('file/arsip'), $fileName);
                    $validatedData['file'] = $fileName;
                }
            }
            $arsips = Arsip::create($validatedData);
            $url = '/admin/arsip';

            return response()->json([
                'status' => 'success',
                'message' => 'Add arsip seccessfull',
                'arsip' => $arsips,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add arsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $arsips = Arsip::with('Program','JenisArsip')->findOrFail($id);
            $url = sprintf('/admin/arsip/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get arsip successful',
                'arsip' => $arsips,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get arsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            $arsips = arsip::findOrfail($id);

            $validatedData = $request->validate([
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'programs_id' => 'required|exists:programs,id',
                'jenisarsips_id' => 'required|exists:jenis_arsips,id',
            ]);

            if ($request->hasFile('file')) {
                if ($arsips->file) {
                    File::delete(public_path('file/arsip' . $arsips->file));
                }

                $files = $request->file('file');
                $FileName = uniqid('arsip_') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('file/arsip'), $FileName);
                $validatedData['file'] = $FileName;
            } else {
                $validatedData['file'] = $donasis->file;
            }
            $arsips->update($validatedData);
            $url = '/admin/arsip';

            return response()->json([
                'status' => 'success',
                'message' => 'Update arsip seccesfull',
                'arsip' => $arsips,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update arsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $arsips = arsip::findOrFail($id);

            if ($arsips->file) {
                File::delete(public_path('file/arsip/' . $arsips->file));
            }

            $arsips->delete();
            $url = '/admin/arsip';

            return response()->json([
                'status' => 'success',
                'message' => 'arsip has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove arsip',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}