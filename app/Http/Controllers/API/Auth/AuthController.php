<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     // dd($request);
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $authUser = Auth::user();
    //         $success['token'] = $authUser->createToken('auth_token')->plainTextToken;
    //         $success['name'] = $authUser->name;

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Login Berhasil',
    //             'data' => $success
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Cek kembali email dan password',
    //             'data' => null
    //         ], 401); // Mengembalikan response dengan HTTP status code 401 (Unauthorized)
    //     }
    // }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'alamat' => 'required',
            'telephone' => 'required|max:15',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'alamat' => $validatedData['alamat'],
            'telephone' => $validatedData['telephone'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'User',
        ]);

        $token = $user->createToken('User')->plainTextToken;
        
        $cookieName = 'access_token';
        $cookieLifetime = 60 * 24;

        $cookie = cookie($cookieName, $token, $cookieLifetime);

        $url = '/apps/dashboard';

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful',
            'token' => $token,
            'url' => $url
        ])->withCookie($cookie);
    }


     public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            session()->regenerate();

            csrf_token();

            $user = Auth::user();

            $token = $user->createToken('User')->plainTextToken;

            $cookieName = 'access_token';
            $cookieLifetime = 60 * 24;

            $cookie = cookie($cookieName, $token, $cookieLifetime);

            $url = '/apps/dashboard';

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
                'url' => $url
            ])->withCookie($cookie);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        $user = Auth::guard('sanctum')->user();

        // auth()->logout();
        Session()->flush();

        if($user){
            $user->tokens()->delete();
        }

        $url = '/auth';

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful',
            'url' => $url
        ])->withoutCookie('access_token');
    }
}