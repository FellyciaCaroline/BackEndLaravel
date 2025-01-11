<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email',
            'password'      => 'required',
            'c_password'    => 'required|same:password'
        ]);

        if ($validator->fails()) {
            // return $this->sendError('Validasi gagal', $validator->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data'    => $validator->errors()
            ], 400);
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            // simpan ke tabel user
            $user = User::create($input);
            // generate token ==> simpan data ke tabel personal access token
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            // ambil nama user
            $success['user'] = $user->name;
            // return $this->sendResponse($success, 'User berhasil didaftarkan');
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil didaftarkan',
                'data'    => $success
            ], 200);
        }
    }

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
