<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan KUD Gajah Mada' }}</title>
    <style>
        /* Margin kertas dipertahankan untuk menyisakan ruang bagi nomor halaman */
        @page { margin: 30px 40px 60px 40px; }
        
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-2 { margin-bottom: 10px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px;}
        .data-table th, .data-table td { border: 1px solid #000; padding: 6px; vertical-align: top;}
        .data-table th { background-color: #e5e7eb; font-weight: bold; text-align: center; }
        
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

    @include('reports._signature')

    <script type="text/php">
        if (isset($pdf)) {
            // Pengaturan Font & Warna
            $font = $fontMetrics->get_font("Helvetica", "italic");
            $size = 9;
            $textColor = array(0.4, 0.4, 0.4); // #666666
            $lineColor = array(0.86, 0.86, 0.86); // #dddddd
            
            // Dimensi Kertas
            $w = $pdf->get_width();
            $h = $pdf->get_height();
            
            // 1. MENGGAMBAR GARIS BORDER-TOP
            $y_line = $h - 45; 
            $pdf->line(40, $y_line, $w - 40, $y_line, $lineColor, 1);
            
            // 2. MENULIS TEKS NOMOR HALAMAN
            $text = "Dicetak dari Sistem Informasi Manajemen KUD Gajah Mada | Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            
            // TRIK PRESISI: Gunakan dummy text untuk menghitung lebar teks agar tidak meleset
            $dummy_text = "Dicetak dari Sistem Informasi Manajemen KUD Gajah Mada | Halaman 9 dari 9";
            $text_width = $fontMetrics->get_text_width($dummy_text, $font, $size);
            
            // Posisi X (Rata Kanan Presisi)
            $x_text = $w - 40 - $text_width;
            
            // Posisi Y (Di bawah garis)
            $y_text = $y_line + 8; 
            
            $pdf->page_text($x_text, $y_text, $text, $font, $size, $textColor);
        }
    </script>

    <div class="watermark">
    <img src="{{ public_path('logo/kud-logo.jpg') }}" alt="logo">
</div>

<style>
    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px; /* Atur ukuran logo sesuai keinginan */
        height: 300px;
        opacity: 0.15; /* Transparansi 15% agar tidak menutupi teks */
        z-index: -1000; /* Pastikan di belakang semua elemen */
        display: block;
    }
    
    .watermark img {
        width: 100%;
        height: auto;
    }
</style>
</body>
</html>