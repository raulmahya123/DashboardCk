<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'userId'   => 'required|string',
            'password' => 'required|string'
        ]);

        $userId = $request->input('userId');
        $password = $request->input('password');

        \Log::info("Raw Password (Tanpa Hashing): '{$password}'");

        // Panggil function login di Model
        $user = User::login($userId, $password);

        if ($user !== null) {
            $loginResult = $user->LoginResult ?? 0;
            $loginMessage = $user->LoginResultMessage ?? 'Login Gagal';

            if ($loginResult == 1) {
                // Panggil Stored Procedure untuk mendapatkan menu otorisasi
                $menus = User::getUserMenuAuth($userId);

                // Simpan user & menu ke dalam session
                Session::put('user', $user);
                Session::put('user_menus', $menus);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Berhasil!',
                    'redirect' => route('dashboard')
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $loginMessage
                ], 401);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID atau Password salah!'
            ], 401);
        }
    }

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('dashboard', [
            'menus' => Session::get('user_menus') // Kirim menu ke tampilan
        ]);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Logout Berhasil!');
    }
}
