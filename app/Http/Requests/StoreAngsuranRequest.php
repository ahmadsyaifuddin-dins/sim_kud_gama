<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAngsuranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->merge([
            'jumlah_bayar' => str_replace(['Rp', '.', ' '], '', $this->jumlah_bayar),
        ]);

        return [
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'angsuran_ke' => 'required|integer|min:1',
            'jumlah_bayar' => 'required|numeric|min:10000',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
