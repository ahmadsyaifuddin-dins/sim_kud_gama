<?php

namespace App\Http\Requests;

use App\Models\Member;
use App\Services\LoanCalculator;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePinjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Siapkan dan bersihkan data sebelum divalidasi.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('jumlah_pinjaman')) {
            $this->merge([
                // Membersihkan format mata uang sebelum divalidasi sebagai numerik
                'jumlah_pinjaman' => str_replace(['Rp', '.', ' '], '', $this->jumlah_pinjaman),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'member_id' => 'required|exists:members,id',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric|min:10000',
            'lama_angsuran' => 'required|integer|min:1|max:60',
            'jenis_bunga' => 'required|in:flat,menurun',
            'persentase_bunga' => 'required|numeric|min:0|max:12',
            'keperluan' => 'required|string|max:255',

            // Aturan 'status' dihapus karena field pada UI form bersifat disabled
            // dan perubahannya sudah di-handle oleh UpdateStatusPinjamanRequest
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $member = Member::find($this->member_id);

            if (! $member) {
                return;
            }

            $plafond = LoanCalculator::plafond($member);
            $nominal = (float) ($this->jumlah_pinjaman);

            if ($nominal <= 0) {
                return;
            }

            if ($plafond <= 0) {
                $validator->errors()->add('jumlah_pinjaman', 'Anggota belum memiliki plafond pinjaman karena belum memiliki lahan sawit dan/atau saldo Simpanan Pokok + Wajib.');
            } elseif ($nominal > $plafond) {
                $validator->errors()->add(
                    'jumlah_pinjaman',
                    'Nominal pinjaman melebihi batas maksimal plafond sebesar Rp '.number_format($plafond, 0, ',', '.').' (ditetapkan berdasarkan luas lahan sawit atau saldo Simpanan Pokok + Wajib).'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'jenis_bunga.required' => 'Jenis perhitungan bunga wajib dipilih.',
            'jenis_bunga.in' => 'Jenis perhitungan bunga tidak valid.',
            'persentase_bunga.required' => 'Persentase jasa per bulan wajib diisi.',
            'persentase_bunga.numeric' => 'Persentase jasa harus berupa angka.',
        ];
    }
}