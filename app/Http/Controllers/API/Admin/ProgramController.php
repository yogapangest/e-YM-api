<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProgramController extends Controller
{
    public function index()
    {
        try {
            $programs = Program::all();

            return response()->json([
                'status' => 'succes',
                'message' => 'Get data program successfull',
                'program' => $programs,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to get program: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_program' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,jpg,png|max:2048',

            ]);
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                if ($files->isValid()) {
                    $fileName = uniqid('program_') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('file/program'), $fileName);
                    $validatedData['file'] = $fileName;
                }
            }
            $programs = Program::create($validatedData);
            $url = '/apps/program/view';

            return response()->json([
                'status' => 'success',
                'message' => 'Add program seccessfull',
                'program' => $programs,
                'url' => $url,
            ]);
        }
        catch (ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }catch (\Exception $e) {
            Log::error('Failed to add program: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $programs = Program::findOrFail($id);

            $url = sprintf('/admin/program/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get program successful',
                'program' => $programs,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get program: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $programs = Program::findOrfail($id);

            $validatedData = $request->validate([
                'nama_program' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,jpg,png|max:2048',
            ]);

            if ($request->hasFile('file')) {
                if ($programs->file) {
                    File::delete(public_path('file/program' . $programs->file));
                }

                $files = $request->file('file');
                $FileName = uniqid('program_') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('file/program'), $FileName);
                $validatedData['file'] = $FileName;
            } else {
                $validatedData['file'] = $donasis->file;
            }
            $programs->update($validatedData);
            $url = '/apps/program/view';

            return response()->json([
                'status' => 'success',
                'message' => 'Update program successful',
                'program' => $programs,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update program: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $programs = Program::findOrFail($id);

            if ($programs->file) {
                File::delete(public_path('file/program/' . $programs->file));
            }

            $programs->delete();
            $url = '/admin/program';

            return response()->json([
                'status' => 'success',
                'message' => 'Program has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to remove program: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove program',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}