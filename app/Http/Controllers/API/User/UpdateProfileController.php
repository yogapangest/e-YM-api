<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UpdateProfileController extends Controller
{
    public function edit()
    {
        try {
            // Mengambil user yang sedang login
            $user = Auth::user();

            // Respond dengan data user
            return response()->json([
                'success' => true,
                'message' => 'User data retrieved successfully',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            // Handle errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function update(Request $request)
    {
        $user = auth()->user(); // Mengambil user yang sedang login

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required',
            'alamat' => 'required',
            'telephone' => 'required|max:15',
            'password' => 'sometimes|min:6',
            'confirm_password' => 'sometimes|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            // Update data user
            $input = $request->all();
            if ($request->has('password')) {
                $input['password'] = bcrypt($input['password']);
            } else {
                unset($input['password']);
            }
            $user->update($input);

            // Respond dengan sukses
            return response()->json([
                'success' => true,
                'message' => 'Update Berhasil',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
