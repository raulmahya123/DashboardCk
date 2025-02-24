<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
class User extends Model
{
    public static function login($userId, $hashedPassword)
    {
        $clientIP = request()->ip();
        $browser = request()->header('User-Agent');

        \Log::info("Login attempt: UserID={$userId}, IP={$clientIP}, Browser={$browser}");

        try {
            // Gunakan koneksi PDO dari Laravel
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('EXEC SAspTrxUserLoginCheck ?, ?, ?, ?');
            $stmt->execute([$userId, $hashedPassword, $clientIP, $browser]);

            $results = [];

            do {
                $rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($rowset) {
                    $results[] = $rowset; // Simpan semua result set
                }
            } while ($stmt->nextRowset());

            // Log hasil query untuk debugging
            \Log::info('oktest: ' . json_encode($results, JSON_PRETTY_PRINT));

            // Jika stored procedure tidak mengembalikan hasil, return 401
            if (empty($results) || empty($results[0])) {
                \Log::warning("Login failed: No data returned");
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Jika ada data, ambil hanya array pertama untuk validasi login
            return $results[0];

        } catch (\Exception $e) {
            \Log::error("Login error: " . $e->getMessage());
            return response()->json(['error' => 'Login failed'], 401);
        }
    }



    public static function getUserMenuAuth($userId)
    {
        // Panggil Stored Procedure untuk mendapatkan menu otorisasi
        $menus = DB::select("EXEC SAspGetUserMenuAuth ?", [$userId]);

        \Log::info("User Menu Auth Output:", (array) $menus);

        return $menus; // Kembalikan daftar menu
    }
}
