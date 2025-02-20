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

        // Panggil Stored Procedure tanpa hashing ulang
        $result = DB::select("EXEC SAspTrxUserLoginCheck ?, ?, ?, ?", [
            $userId,
            $hashedPassword,
            $clientIP,
            $browser
        ]);

        \Log::info("Stored Procedure Output:", (array) $result);

        if (!empty($result) && isset($result[0]->LoginResult)) {
            return $result[0]; // Login sukses
        }

        return null; // Login gagal
    }
}
