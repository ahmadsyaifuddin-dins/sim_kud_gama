<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Anggota Baru - KUD GM</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 py-10 px-4 font-sans">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden">
        <div class="bg-pink-700 py-6 px-8 text-center">
            <h2 class="text-2xl font-bold text-white">Formulir Pendaftaran Anggota Baru</h2>
            <p class="text-pink-100 text-sm mt-1">Silakan isi data dengan benar sesuai KTP & Sertifikat Lahan</p>
        </div>

        <div class="px-8 pt-6">
            <x-alerts.error />
        </div>

        <form action="{{ route('public.store') }}" method="POST" enctype="multipart/form-data" class="p-8 pt-4 space-y-8">
            @csrf

            {{-- SECTION 1: DATA PRIBADI --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">1. Data Pribadi</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    
                    <div>
                        <x-forms.label value="Nama Lengkap" required="true" />
                        <x-forms.input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP" required />
                        @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="NIK (Nomor KTP)" required="true" />
                        <x-forms.numeric-input name="nik" mode="nik" required="true" placeholder="16 Digit Angka" />
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="Tempat Lahir" required="true" />
                        <x-forms.input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota/Kabupaten" required />
                        @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="Tanggal Lahir" required="true" />
                        <x-forms.input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required />
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="Jenis Kelamin" required="true" />
                        <x-forms.dropdown name="jenis_kelamin" required>
                            <option value="" disabled {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </x-forms.dropdown>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="No HP / WA" required="true" />
                        <x-forms.numeric-input name="no_hp" mode="no_hp" required="true" placeholder="Awalan 08xxx (Misal: 0812...)" />
                        <p class="text-[10px] text-gray-500 mt-1 font-medium">
                            <i class="fa-solid fa-circle-info text-blue-500 mr-1"></i>
                            Pastikan nomor aktif di WhatsApp untuk <b>notifikasi</b> dan dimulai dengan awalan <strong>08xxx</strong>.
                        </p>
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>

            {{-- SECTION 2: ALAMAT & LAHAN --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">2. Alamat & Lahan</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    
                <div class="md:col-span-2">
                    <x-forms.label value="Alamat Lengkap (Jalan/RT/RW)" required="true" />
                    <textarea name="alamat_lengkap" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 border p-2 text-sm">{{ old('alamat_lengkap') }}</textarea>
                    
                    {{-- Keterangan Helper untuk Alamat Domisili --}}
                    <p class="text-[10px] text-gray-500 mt-1.5 font-medium">
                        <i class="fa-solid fa-circle-info text-blue-500 mr-1"></i>
                        Masukkan alamat <strong>domisili / tempat tinggal</strong> saat ini sesuai KTP, bukan alamat lokasi lahan sawit.
                    </p>
                    
                    @error('alamat_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                    <div>
                        <x-forms.label value="Dusun" required="true" />
                        <x-forms.dropdown name="dusun" required>
                            <option value="" disabled {{ old('dusun') == '' ? 'selected' : '' }}>-- Pilih Dusun --</option>
                            @php
                                $daftarDusun = ['Dusun I', 'Dusun II', 'Dusun III', 'Dusun Melati', 'Muara Ujung'];
                            @endphp
                            @foreach($daftarDusun as $dsn)
                                <option value="{{ $dsn }}" {{ old('dusun') == $dsn ? 'selected' : '' }}>{{ $dsn }}</option>
                            @endforeach
                        </x-forms.dropdown>
                        <p class="text-[10px] text-gray-500 mt-1 font-medium">
                            *Hanya menampilkan daftar dusun di Desa Telaga Sari.
                        </p>
                        @error('dusun') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="Desa" required="true" />
                        <input type="text" name="desa" value="Telaga Sari" readonly
                            class="block w-full mt-1 text-sm bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed text-gray-500 font-bold focus:ring-0">
                        <div class="text-[10px] text-gray-500 mt-1.5 font-medium leading-relaxed">
                            <div class="flex items-start gap-1.5">
                                <i class="fa-solid fa-lock text-gray-400 mt-0.5"></i>
                                <ul class="list-disc list-inside">
                                    <li>Data desa bersifat tetap dan tidak dapat diubah.</li>
                                    <li>KUD beroperasi khusus di wilayah Desa Telaga Sari.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
        <x-forms.label value="Luasan Lahan Sawit" required="true" />
        <div class="relative mt-1 md:w-1/2">
            <input type="number" step="0.01" name="luasan_lahan" value="{{ old('luasan_lahan') }}" required
                class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500 pr-10"
                placeholder="Contoh: 2.5">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <span class="text-gray-500 sm:text-sm font-bold">Ha</span>
            </div>
        </div>
        
        {{-- Keterangan Helper untuk User --}}
        <p class="text-[10px] text-gray-500 mt-1.5 font-medium">
            <i class="fa-solid fa-circle-info text-blue-500 mr-1"></i>
            Masukkan angka bulat (misal: <strong>2</strong>) atau gunakan tanda <strong>titik</strong> untuk desimal (misal: <strong>3.5</strong>). Jangan gunakan koma.
        </p>
        
        @error('luasan_lahan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

                </div>
            </div>

            {{-- SECTION 3: UPLOAD BERKAS --}}
            <div>
        {{-- Wrapper Header Section: Garis pemisah diletakkan di sini agar membungkus judul dan teks --}}
        <div class="border-b border-gray-200 pb-3 mb-5">
            <h3 class="text-lg font-semibold text-gray-800">3. Upload Berkas Persyaratan (Wajib)</h3>
            <p class="text-xs text-gray-500 font-medium mt-1.5">
                Silakan unggah dokumen berikut sebagai syarat pendaftaran <strong class="text-pink-600">Calon Anggota Baru</strong>. Berkas akan diverifikasi oleh pengurus KUD Gajah Mada.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6 bg-pink-50 p-5 rounded-xl border border-pink-100">
            
            <div>
                <x-forms.label value="Pas Foto (JPG/PNG)" required="true" />
                <x-forms.upload-file name="foto" accept="image/*" required />
                <p class="text-[10px] text-gray-500 mt-1">Maksimal 2MB. Digunakan untuk Kartu Anggota.</p>
                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

                    <div>
                        <x-forms.label value="Scan / Foto KTP" required="true" />
                        <x-forms.upload-file name="file_ktp" accept=".pdf,image/*" required />
                        <p class="text-[10px] text-gray-500 mt-1">Maksimal 2MB (PDF/JPG/PNG).</p>
                        @error('file_ktp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="Scan / Foto KK" required="true" />
                        <x-forms.upload-file name="file_kk" accept=".pdf,image/*" required />
                        <p class="text-[10px] text-gray-500 mt-1">Maksimal 2MB (PDF/JPG/PNG).</p>
                        @error('file_kk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-forms.label value="Scan Sertifikat Tanah" required="true" />
                        <x-forms.upload-file name="file_sertifikat_tanah" accept=".pdf,image/*" required />
                        <p class="text-[10px] text-gray-500 mt-1">Maksimal 2MB (PDF/JPG/PNG). Bukti kepemilikan lahan sah.</p>
                        @error('file_sertifikat_tanah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="pt-6 border-t flex justify-between items-center">
                <a href="{{ route('landing') }}" class="text-gray-500 hover:text-gray-800 hover:underline font-medium">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-pink-700 text-white font-bold rounded-lg shadow-lg hover:bg-pink-800 focus:ring-4 focus:ring-pink-300 transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pendaftaran
                </button>
            </div>
        </form>
    </div>

</body>
</html>