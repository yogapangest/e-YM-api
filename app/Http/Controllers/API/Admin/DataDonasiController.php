<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DataDonasiController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('role','User')->get();

            $url = '/admin/user';

            return response()->json([
                'status' => 'success',
                'message' => 'Get data user successfull',
                'user' => $users,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'alamat' => 'required',
            'telephone' => 'required|max:15',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'data' => $validator->errors()
            ], 422); // Mengembalikan response dengan HTTP status code 422 (Unprocessable Entity)
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 'User';

        $user = User::create($input);

        $success['email'] = $user->email;
        $success['name'] = $user->name;
        $success['username'] = $user->username;
        $success['alamat'] = $user->alamat;
        $success['telephone'] = $user->telephone;

        return response()->json([
            'success' => true,
            'message' => 'Create Berhasil',
            'data' => $success
        ], 201);
    }

    public function edit($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Respond with the user data
            return response()->json([
                'success' => true,
                'message' => 'User data retrieved successfully',
                'user' => $user,
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'alamat' => 'required',
            'telephone' => 'required|max:15',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Update user data
            $input = $request->all();
            if ($request->has('password')) {
                $input['password'] = bcrypt($input['password']);
            } else {
                unset($input['password']);
            }
            $user->update($input);

            // Respond with success
            return response()->json([
                'success' => true,
                'message' => 'Update Berhasil',
                'data' => $user
            ]);
        } catch (Exception $e) {
            // Handle errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $datadonasis = User::findOrFail($id);

            $datadonasis->delete();
            $url = '/admin/datadonasi';

            return response()->json([
                'status' => 'success',
                'message' => 'data donasi has been removed',
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove data donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}