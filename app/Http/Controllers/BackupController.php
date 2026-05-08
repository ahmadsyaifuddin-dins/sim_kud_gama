<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class BackupController extends Controller
{
    public function downloadSql()
    {
        $database = env('DB_DATABASE', 'sim_kud_gama');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $host = env('DB_HOST', '127.0.0.1');

        // Ambil path dari .env (untuk lokal Laragon) atau gunakan default (untuk server cPanel/VPS)
        $dumpPath = env('DB_DUMP_PATH', 'mysqldump');

        $fileName = 'backup_kud_gama_'.now()->format('Y-m-d_H-i-s').'.sql';
        $filePath = storage_path('app/'.$fileName);

        $passwordString = $password ? "--password={$password}" : '';

        // Eksekusi mysqldump tanpa simbol '>'
        $command = "\"{$dumpPath}\" --user={$username} {$passwordString} --host={$host} {$database}";

        // Jalankan perintah
        $result = Process::run($command);

        if ($result->successful()) {
            // Tangkap output dan simpan ke file
            File::put($filePath, $result->output());

            // Download dan otomatis hapus file dari server setelah selesai
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        // Tampilkan error asli dari terminal jika masih gagal
        return back()->withErrors(['backup' => 'Gagal backup: '.$result->errorOutput()]);
    }
}
