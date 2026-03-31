<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePinjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Membersihkan format Rupiah sebelum divalidasi
        $this->merge([
            'jumlah_pinjaman' => str_replace(['Rp', '.', ' '], '', $this->jumlah_pinjaman),
        ]);

        return [
            'member_id' => 'required|exists:members,id',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric|min:10000',
            'lama_angsuran' => 'required|integer|min:1',
            'keperluan' => 'required|string|max:255',
        ];
    }
}
