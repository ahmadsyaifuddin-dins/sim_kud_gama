<x-alerts.error />

<div class="grid grid-cols-1 gap-6 mt-4">
    <div>
        <x-forms.label value="Nama Lengkap" required="true" />
        <x-forms.input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required />
        @error('name')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Email Address" required="true" />
        <x-forms.input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required />
        @error('email')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Role / Hak Akses" required="true" />
        <x-forms.dropdown name="role" required>
            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator (Full
                Access)</option>
            <option value="pimpinan" {{ old('role', $user->role ?? '') == 'pimpinan' ? 'selected' : '' }}>Pimpinan /
                Ketua KUD (View Only & Reports)</option>
        </x-forms.dropdown>
        @error('role')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label required="{{ isset($user) ? 'false' : 'true' }}">
            Password
            @if (isset($user))
                <span class="text-xs text-gray-500 font-normal">(Kosongkan jika tidak ingin mengganti)</span>
            @endif
        </x-forms.label>
        <x-forms.input type="password" name="password" :required="!isset($user)" />
        @error('password')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Konfirmasi Password" required="{{ isset($user) ? 'false' : 'true' }}" />
        <x-forms.input type="password" name="password_confirmation" :required="!isset($user)" />
    </div>
</div>

<div class="flex justify-end mt-6">
    <button type="submit"
        class="px-6 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue shadow-md">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                </path>
            </svg>
            {{ $submit_text ?? 'Simpan Data User' }}
        </div>
    </button>
</div>
