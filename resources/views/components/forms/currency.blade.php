@props(['name', 'value' => '', 'placeholder' => '0'])

<div x-data="{
    raw_value: '{{ $value }}',
    formatted_value: '',
    formatRupiah(angka) {
        let number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    },
    init() {
        this.formatted_value = this.raw_value ? this.formatRupiah(this.raw_value) : '';
    }
}" class="relative">

    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <span class="text-gray-500 sm:text-sm">Rp</span>
    </div>

    <input type="text" x-model="formatted_value"
        @input="
            raw_value = $event.target.value.replace(/\./g, '');
            formatted_value = formatRupiah(raw_value);
        "
        class="pl-10 border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm w-full"
        placeholder="{{ $placeholder }}" {{ $attributes }}>

    <input type="hidden" name="{{ $name }}" :value="raw_value">
</div>
