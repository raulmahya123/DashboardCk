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

        // Panggil Stored Procedure
        $result = DB::select("EXEC SAspTrxUserLoginCheck ?, ?, ?, ?", [
            $userId,
            $hashedPassword,
            $clientIP,
            $browser
        ]);

        \Log::info("Stored Procedure Output:", (array) $result);

        // Pastikan hasilnya tidak kosong dan ambil indeks pertama
        if (!empty($result)) {
            return $result[0]; // Ambil objek pertama
        }

        return null; // Login gagal
    }
}

