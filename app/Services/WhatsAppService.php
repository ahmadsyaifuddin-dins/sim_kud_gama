<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function send(string $target, string $message): bool
    {
        // Format nomor HP ke standar Fonnte (mengganti 0 dengan 62)
        $formattedNumber = self::formatNumber($target);

        try {
            $response = Http::withHeaders([
                // Pastikan token Fonnte disimpan di file .env
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $formattedNumber,
                'message' => $message,
                'countryCode' => '62', // Opsional
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Fonnte Error: '.$e->getMessage());

            return false;
        }
    }

    private static function formatNumber(string $number): string
    {
        if (substr($number, 0, 1) === '0') {
            return '62'.substr($number, 1);
        }

        return $number;
    }
}
