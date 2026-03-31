<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Cek apakah ini proses update (ada ID) atau create
        $memberId = $this->route('member') ? $this->route('member')->id : null;

        return [
            // Admin Specific: Nomor Anggota wajib & unik
            'nomor_anggota' => 'required|string|unique:members,nomor_anggota,'.$memberId,

            // NIK: Wajib angka, 16 digit, unik
            'nik' => 'required|numeric|digits:16|unique:members,nik,'.$memberId,

            // No HP: Wajib angka, 10-15 digit (Nullable agar admin bisa kosongkan jika belum ada data)
            'no_hp' => 'nullable|numeric|digits_between:10,15',

            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_lengkap' => 'required|string',
            'dusun' => 'required|string',
            'pekerjaan' => 'nullable|string',
            'luasan_lahan' => 'required|numeric|min:0.1',

            // Dokumen (Nullable saat update, agar tidak wajib upload ulang)
            'file_sertifikat_tanah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'tanggal_bergabung' => 'required|date',

            // Pembayaran
            'file_bukti_bayar' => 'nullable|image|max:2048',
            'tanggal_bayar' => 'nullable|date',
            'status' => 'sometimes|in:active,inactive,stopped,pending',

            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    /**
     * Custom Pesan Error (Bahasa Indonesia)
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'numeric' => ':attribute harus berupa angka.',
            'date' => ':attribute format tanggal tidak valid.',
            'image' => ':attribute harus berupa file gambar (jpg, jpeg, png).',
            'mimes' => ':attribute harus berupa file tipe: :values.',
            'max' => 'Ukuran :attribute maksimal 2MB.',
            'unique' => ':attribute sudah terdaftar di sistem.',
            'digits' => ':attribute harus berjumlah :digits digit.',
            'digits_between' => ':attribute harus berjumlah antara :min sampai :max digit.',
            'in' => 'Pilihan :attribute tidak valid.',
            'min' => ':attribute minimal :min.',
        ];
    }

    /**
     * Label Atribut agar pesan error lebih enak dibaca
     */
    public function attributes(): array
    {
        return [
            'nomor_anggota' => 'Nomor Anggota',
            'nik' => 'NIK',
            'no_hp' => 'Nomor HP',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat_lengkap' => 'Alamat',
            'dusun' => 'Dusun',
            'luasan_lahan' => 'Luas Lahan',
            'file_sertifikat_tanah' => 'File Sertifikat',
            'file_ktp' => 'File KTP',
            'file_kk' => 'File KK',
            'file_bukti_bayar' => 'Bukti Bayar',
            'foto' => 'Pas Foto',
        ];
    }
}
