@props(['name', 'mode' => 'default', 'required' => 'false', 'placeholder' => '', 'value' => ''])

@php
    // Tentukan maksimal karakter berdasarkan mode (NIK = 16 digit, No HP = 15 digit)
    $maxLength = $mode === 'nik' ? 16 : ($mode === 'no_hp' ? 15 : 255);
@endphp

{{-- Inisialisasi Alpine.js untuk menampung nilai inputan --}}
<div x-data="{ inputValue: '{{ old($name, $value) }}' }" class="relative mt-1">
    <input 
        type="text" 
        name="{{ $name }}" 
        x-model="inputValue"
        {{-- Mencegah user mengetik huruf, hanya angka (0-9) dan memotong panjang karakter otomatis --}}
        @input="inputValue = inputValue.replace(/[^0-9]/g, '').substring(0, {{ $maxLength }})"
        placeholder="{{ $placeholder }}"
        {!! $attributes->merge([
            'class' => 'border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm w-full pr-16'
        ]) !!}
        {{ $required === 'true' || $required === true ? 'required' : '' }}
    />
    
    {{-- Indikator Counter Khusus Mode NIK --}}
    @if($mode === 'nik')
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            {{-- Berubah jadi hijau tebal kalau pas 16 digit --}}
            <span class="text-xs transition-colors duration-200" 
                  :class="inputValue.length === 16 ? 'text-green-600 font-bold' : 'text-gray-400 font-medium'">
                <span x-text="inputValue.length"></span>/16
            </span>
        </div>
    @endif
</div>