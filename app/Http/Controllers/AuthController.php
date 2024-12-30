<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        // jika email dan password terdaftar di tabel users
        if (Auth::attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ])) {
            $user = Auth::user();
            // Generate token, simpan ke tabel personal access token
            $success['token'] = $user->createToken('bunga')->plainTextToken;
            $success['user'] = $user->name;
            // return $this->sendResponse($success, 'Login berhasil');
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data'    => $success
            ], 200);
        } else {
            // email dan password salah
            // return $this->sendError('Login gagal', ['error' => 'Email atau password salah']);
            return response()->json([
                'success' => false,
                'message' => 'Login gagal',
                'data'    => ['error' => 'Email atau password salah']
            ], 401);
        }

    }

    public function logout(Request $request)
    {
        $user = Auth::user(); // Mengambil pengguna yang sedang login
        if ($user) {
            // Menghapus semua token terkait pengguna
            $user->tokens->each->delete();
        }
        Auth::logout(); // Logout pengguna
        return response()->json(['message' => 'Logout berhasil']);
    }

}
