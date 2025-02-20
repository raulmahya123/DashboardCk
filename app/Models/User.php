<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public static function login($userId, $hashedPassword)
    {
        $clientIP = request()->ip();
        $browser = request()->header('User-Agent');

        \Log::info("Login attempt: UserID={$userId}, IP={$clientIP}, Browser={$browser}");

        // Panggil Stored Procedure Login
        $result = DB::select("EXEC SAspTrxUserLoginCheck ?, ?, ?, ?", [
            $userId,
            $hashedPassword,
            $clientIP,
            $browser
        ]);

        \Log::info("Stored Procedure Output:", (array) $result);

        // Jika login berhasil, ambil hasilnya
        return !empty($result) ? $result[0] : null;
    }

    public static function getUserMenuAuth($userId)
    {
        // Panggil Stored Procedure untuk mendapatkan menu otorisasi
        $menus = DB::select("EXEC SAspGetUserMenuAuth ?", [$userId]);

        \Log::info("User Menu Auth Output:", (array) $menus);

        return $menus; // Kembalikan daftar menu
    }
}
