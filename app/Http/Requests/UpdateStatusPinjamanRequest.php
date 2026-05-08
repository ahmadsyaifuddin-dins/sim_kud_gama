<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusPinjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan gate/policy jika ada
    }

    public function rules(): array
    {
        return [
            // Status harus sesuai enum tabel pinjaman
            'status' => 'required|in:menunggu,disetujui,ditolak,lunas',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
        ];
    }
}
