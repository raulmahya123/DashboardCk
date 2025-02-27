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
            // Panggil stored procedure menggunakan Laravel Query Builder
            $results = DB::select('EXEC SAspTrxUserLoginCheck ?, ?, ?, ?', [
                $userId, 
                $hashedPassword, 
                $clientIP, 
                $browser
            ]);

            \Log::info('Stored Procedure Results: ' . json_encode($results, JSON_PRETTY_PRINT));

            if (empty($results)) {
                Log::warning('Login failed: No data returned');
                return null;
            }

            // Mengembalikan hasil stored procedure sebagai stdClass
            return $results;
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return null;
        }
    }


    public static function getUserMenuAuth($userId)
    {
        // Panggil stored procedure untuk mendapatkan daftar menu
        $menus = DB::select('EXEC SAspGetUserMenuAuthDashboard ?', [$userId]);

        \Log::info('User Menu Auth Output:', ['menus' => $menus]);

        if (empty($menus)) {
            \Log::error("Data menu tidak ditemukan untuk userId: $userId");
            return [];
        }

        // Loop melalui setiap menu untuk mendapatkan FormType
        foreach ($menus as $menu) {
            if (!empty($menu->FormURLAddress) && str_contains($menu->FormURLAddress, 'FormType=')) {
                parse_str(parse_url($menu->FormURLAddress, PHP_URL_QUERY), $queryParams);
                $formType = $queryParams['FormType'] ?? null;

                if ($formType) {
                    \Log::info('Memanggil wsSAspGetLinkPowerBI dengan', [
                        'formType' => $formType,
                        'userId' => $userId,
                    ]);

                    // Panggil stored procedure Power BI
                    $powerBILinkResult = DB::select('EXEC wsSAspGetLinkPowerBI ?, ?', [$formType, $userId]);

                    \Log::info('Hasil Query Power BI:', ['result' => $powerBILinkResult]);

                    // Pastikan hasil query tidak kosong sebelum ditugaskan
                    if (!empty($powerBILinkResult)) {
                        $firstResult = $powerBILinkResult[0]; // Ambil elemen pertama
                        if (isset($firstResult->stdClass) && isset($firstResult->stdClass->LinkPowerBI)) {
                            $menu->PowerBILink = $firstResult->stdClass->LinkPowerBI;
                        } elseif (isset($firstResult->LinkPowerBI)) {
                            $menu->PowerBILink = $firstResult->LinkPowerBI;
                        } else {
                            $menu->PowerBILink = null;
                        }
                    } else {
                        $menu->PowerBILink = null;
                    }

                    \Log::info("Power BI Link untuk UserId: $userId dan FormType: $formType", [
                        'PowerBILink' => $menu->PowerBILink,
                    ]);
                }
            }
        }

        return $menus;
    }
}
