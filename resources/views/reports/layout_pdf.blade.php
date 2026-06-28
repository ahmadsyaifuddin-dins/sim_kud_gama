<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan KUD Gajah Mada' }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-2 { margin-bottom: 10px; }
        
        /* Tabel Data Utama */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px;}
        .data-table th, .data-table td { border: 1px solid #000; padding: 6px; vertical-align: top;}
        .data-table th { background-color: #e5e7eb; font-weight: bold; text-align: center; }
        
        /* Box Filter & Metadata Dospem Defender */
        .metadata-box { border: 1px dashed #666; padding: 8px; margin-top: 10px; background-color: #f9fafb; font-size: 10px; }
        .metadata-table { width: 100%; border: none; }
        .metadata-table td { padding: 2px 5px; border: none; }
    </style>
</head>
<body>

    @include('reports._header')

    @include('reports._metadata')

    <main>
        @yield('content')
    </main>

    <footer>
    @include('reports._signature', [
        'type' => $type ?? 'biasa', 
        'role' => $role ?? 'Ketua'
    ])
    </footer>

</body>
</html>