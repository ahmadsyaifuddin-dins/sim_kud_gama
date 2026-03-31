<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Bersihkan format titik dan Rp sebelum validasi jalan
        if ($this->has('jumlah')) {
            $this->merge([
                'jumlah' => str_replace(['Rp', '.', ' '], '', $this->jumlah),
            ]);
        }

        return [
            'member_id' => 'required|exists:members,id',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
