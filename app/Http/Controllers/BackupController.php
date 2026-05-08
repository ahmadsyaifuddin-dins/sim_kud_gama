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
        $port = env('DB_PORT', '3306');

        $dumpPath = env('DB_DUMP_PATH', 'mysqldump');

        // Validasi keberadaan file mysqldump
        if ($dumpPath !== 'mysqldump' && ! File::exists($dumpPath)) {
            return back()->withErrors([
                'backup' => "Gagal backup: File mysqldump tidak ditemukan di lokasi: [ {$dumpPath} ]. ".
                            'Silakan periksa kembali folder instalasi Laragon/XAMPP Anda.',
            ]);
        }

        $fileName = 'backup_kud_gama_'.now()->format('Y-m-d_H-i-s').'.sql';
        $filePath = storage_path('app/'.$fileName);

        $passwordString = $password ? "--password={$password}" : '';

        // Tambahkan --port agar koneksi TCP/IP lebih terarah
        $command = "\"{$dumpPath}\" --user={$username} {$passwordString} --host={$host} --port={$port} {$database}";

        // Trik khusus Windows: Suntikkan SYSTEMROOT agar mysqldump bisa menggunakan jaringan TCP/IP
        $systemRoot = getenv('SYSTEMROOT') ?: 'C:\Windows';

        $result = Process::env([
            'SYSTEMROOT' => $systemRoot,
        ])->run($command);

        if ($result->successful()) {
            File::put($filePath, $result->output());

            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return back()->withErrors([
            'backup' => 'Proses mysqldump gagal. Pesan sistem: '.$result->errorOutput(),
        ]);
    }
}
