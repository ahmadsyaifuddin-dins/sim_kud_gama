<div class="grid grid-cols-1 gap-6 mt-4">

    <div>
        <label class="block text-sm text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
            class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
            required>
        @error('name')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-700">Email Address</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
            class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
            required>
        @error('email')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-700">Role / Hak Akses</label>
        <select name="role"
            class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
            required>
            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator
            </option>
            <option value="pimpinan" {{ old('role', $user->role ?? '') == 'pimpinan' ? 'selected' : '' }}>Pimpinan /
                Ketua KUD</option>
        </select>
        @error('role')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-700">
            Password
            @if (isset($user))
                <span class="text-xs text-gray-500">(Kosongkan jika tidak ingin mengganti)</span>
            @endif
        </label>
        <input type="password" name="password"
            class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
            {{ isset($user) ? '' : 'required' }}>
        @error('password')
            <span class="text-xs text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
            class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
            {{ isset($user) ? '' : 'required' }}>
    </div>

</div>

<div class="flex justify-end mt-6">
    <button type="submit"
        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
        {{ $submit_text ?? 'Simpan' }}
    </button>
</div>
