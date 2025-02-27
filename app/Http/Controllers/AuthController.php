<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Models\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'userId'   => 'required|string',
            'password' => 'required|string'
        ]);

        $userId = $request->input('userId');
        $password = $request->input('password');

        \Log::info("Raw Password: '{$password}'");

        // Panggil function login di Model
        $results = User::login($userId, $password);

        \Log::info('User Login Result: ' . json_encode($results, JSON_PRETTY_PRINT));

        // Cek apakah hasil kosong
        if (empty($results) || !isset($results[0])) {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID atau Password salah!'
            ], 401);
        }

        // Ambil hasil pertama dari stored procedure
        $user = $results[0];

        // Akses nilai dengan operator `->` karena hasilnya stdClass
        $loginResult = $user->LoginResult ?? 0;
        $loginMessage = $user->LoginResultMessage ?? 'Login Gagal';

        if ($loginResult == 1) {
            $menus = User::getUserMenuAuth($userId);

            // Simpan data ke session
            Session::put('user', $user);
            Session::put('user_menus', $menus);
            Session::put('user_details', $results);
            Session::save();

            \Log::info('Session Data After Login: ' . json_encode(session()->all(), JSON_PRETTY_PRINT));

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
    }
    
    
    

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('dashboard', [
            'menus' => Session::get('user_menus')
        ]);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Logout Berhasil!');
    }



}
