<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    /**
     * Mengecek validasi dari QR Code.
     * Bisa menangani scan ID KTA Anggota maupun Token Dokumen Laporan.
     */
    public function check($token)
    {
        // 1. CEK APAKAH INI SCAN DOKUMEN LAPORAN (Format Token Base64)
        $decoded = base64_decode($token, true); 
        
        if ($decoded !== false && str_contains($decoded, '|')) {
            $parts = explode('|', $decoded);
            
            if (count($parts) === 2) {
                $reportType = $parts[0];
                $timestamp = $parts[1];
                
                // Format tanggal cetak agar rapi
                $printDate = Carbon::createFromTimestamp($timestamp)->translatedFormat('d F Y H:i:s');
                
                // Rapikan nama laporan berdasarkan tipe
                $reportName = str_replace('_', ' ', strtoupper($reportType));

                // Arahkan ke view khusus validasi dokumen
                return view('validation.document_result', [
                    'isValid'    => true,
                    'reportName' => $reportName,
                    'printDate'  => $printDate,
                    'message'    => 'Dokumen Valid. Laporan ini resmi dicetak dari Sistem Informasi KUD Gajah Mada.'
                ]);
            }
        }

        // 2. JIKA BUKAN DOKUMEN, ASUMSIKAN INI SCAN KTA ANGGOTA (Format ID)
        if (is_numeric($token)) {
            // Cari anggota, kalau gak ketemu tampilkan 404
            $member = Member::findOrFail($token);

            // Arahkan ke view khusus KTA seperti kodemu sebelumnya
            return view('validation.result', compact('member'));
        }

        // 3. JIKA FORMAT TIDAK DIKENALI
        return view('validation.document_result', [
            'isValid' => false,
            'message' => 'QR Code tidak dikenali atau dokumen tidak valid.'
        ]);
    }
}