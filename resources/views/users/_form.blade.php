<x-alerts.error />

<div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">

    <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-user-circle text-blue-500 mr-2"></i> Informasi Akun
        </h3>
    </div>

    <div>
        <x-forms.label value="Nama Lengkap" required="true" />
        <x-forms.input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
            placeholder="Masukkan nama lengkap" />
        @error('name')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Email Address" required="true" />
        <x-forms.input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
            placeholder="contoh@gmail.com" />
        @error('email')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Role / Hak Akses" required="true" />
        <x-forms.dropdown name="role" required>
            <option value="" disabled {{ old('role', $user->role ?? '') == '' ? 'selected' : '' }}>-- Pilih Hak
                Akses --</option>
            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator
                (Akses Penuh)</option>
            <option value="pimpinan" {{ old('role', $user->role ?? '') == 'pimpinan' ? 'selected' : '' }}>Pimpinan /
                Ketua KUD (Hanya Lihat & Laporan)</option>
        </x-forms.dropdown>
        @error('role')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-lock text-blue-500 mr-2"></i> Keamanan
        </h3>
    </div>

    <div>
        <x-forms.label required="{{ isset($user) ? 'false' : 'true' }}">
            Password
            @if (isset($user))
                <span class="text-xs text-slate-500 font-normal italic ml-1">(Kosongkan jika tidak ingin
                    mengganti)</span>
            @endif
        </x-forms.label>
        <x-forms.input type="password" name="password" :required="!isset($user)" placeholder="••••••••" />
        @error('password')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Konfirmasi Password" required="{{ isset($user) ? 'false' : 'true' }}" />
        <x-forms.input type="password" name="password_confirmation" :required="!isset($user)" placeholder="••••••••" />
    </div>
</div>

<div class="flex justify-end items-center mt-8 pt-4 border-t border-slate-200">
    <button type="submit"
        class="inline-flex items-center px-6 py-2.5 text-sm font-semibold tracking-wide text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-md">
        <i class="fa-solid fa-floppy-disk mr-2 text-lg"></i>
        {{ $submit_text ?? 'Simpan Data User' }}
    </button>
</div>
