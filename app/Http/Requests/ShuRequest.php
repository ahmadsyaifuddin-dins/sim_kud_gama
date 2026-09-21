<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('total_shu')) {
            $this->merge([
                'total_shu' => str_replace(['Rp', '.', ' '], '', $this->total_shu),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'tahun' => 'required|integer|min:2000|max:2100',
            'total_shu' => 'required|numeric|min:0',
            'jasa_modal_persen' => 'required|numeric|min:0|max:100',
            'jasa_transaksi_persen' => 'required|numeric|min:0|max:100',
            'cadangan_persen' => 'required|numeric|min:0|max:100',
            'note' => 'nullable|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $total = (float) $this->jasa_modal_persen
                + (float) $this->jasa_transaksi_persen
                + (float) $this->cadangan_persen;

            if (abs($total - 100) > 0.01) {
                $validator->errors()->add('cadangan_persen', 'Total persentase Jasa Modal + Jasa Transaksi + Cadangan harus tepat 100%.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'tahun.required' => 'Tahun buku wajib dipilih.',
            'total_shu.required' => 'Total SHU wajib diisi.',
            'total_shu.numeric' => 'Total SHU harus berupa angka.',
            'jasa_modal_persen.required' => 'Persentase Jasa Usaha / Modal wajib diisi.',
            'jasa_transaksi_persen.required' => 'Persentase Jasa Transaksi wajib diisi.',
            'cadangan_persen.required' => 'Persentase Cadangan wajib diisi.',
        ];
    }
}