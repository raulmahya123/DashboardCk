<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
use App\Models\Log;

class User extends Model
{
    public static function login($userId, $hashedPassword)
    {
        $clientIP = request()->ip();
        $browser = request()->header('User-Agent');

        \Log::info("Login attempt: UserID={$userId}, IP={$clientIP}, Browser={$browser}");

        try {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('EXEC SAspTrxUserLoginCheck ?, ?, ?, ?');
            $stmt->execute([$userId, $hashedPassword, $clientIP, $browser]);

            $results = [];

            do {
                $rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($rowset) {
                    $results[] = $rowset;
                }
            } while ($stmt->nextRowset());

            \Log::info('Stored Procedure Results: ' . json_encode($results, JSON_PRETTY_PRINT));

            if (empty($results) || empty($results[0])) {
                \Log::warning("Login failed: No data returned");
                return null; // Ubah dari response JSON ke null agar mudah dikelola di controller
            }

            return $results; // Mengembalikan semua dataset yang dihasilkan stored procedure

        } catch (\Exception $e) {
            \Log::error("Login error: " . $e->getMessage());
            return null;
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
