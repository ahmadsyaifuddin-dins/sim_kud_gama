<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang Kembali</h2>
        <p class="mt-1 text-sm text-gray-500">
            Masuk untuk mengelola koperasi KUD Gajah Mada.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Akun email')" class="text-gray-700" />
            <div class="relative mt-1.5">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-pink-500 pointer-events-none">
                    <i class="fa-solid fa-envelope text-sm"></i>
                </span>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="block w-full py-2.5 pl-10 pr-4 text-sm transition-all border border-gray-200 rounded-xl shadow-sm form-input focus:border-pink-500 focus:ring-2 focus:ring-pink-500"
                    placeholder="nama@contoh.com" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-semibold text-pink-600 hover:text-pink-700">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>
            <div class="relative mt-1.5">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-pink-500 pointer-events-none">
                    <i class="fa-solid fa-lock text-sm"></i>
                </span>
                <input type="password" name="password" id="password"
                    class="block w-full py-2.5 pl-10 pr-10 text-sm transition-all border border-gray-200 rounded-xl shadow-sm form-input focus:border-pink-500 focus:ring-2 focus:ring-pink-500"
                    placeholder="••••••••" required autocomplete="current-password" />
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 transition-colors hover:text-pink-600">
                    <i id="passwordEye" class="fa-solid fa-eye text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                <input id="remember" type="checkbox" name="remember"
                    class="w-4 h-4 text-pink-600 transition border-gray-300 rounded focus:ring-pink-500">
                {{ __('Ingat Saya') }}
            </label>
        </div>

        <div class="pt-1">
            <button type="submit"
                class="group relative flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-bold text-white transition-all duration-200 bg-gradient-to-r from-pink-600 via-rose-500 to-fuchsia-600 rounded-xl shadow-lg shadow-pink-300/60 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-pink-400/60 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <i class="fa-solid fa-right-to-bracket"></i>
                {{ __('Masuk ke Sistem') }}
                <i class="fa-solid fa-arrow-right transition-transform duration-200 group-hover:translate-x-1"></i>
            </button>
        </div>

        <p class="pt-1 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} KUD Gajah Mada — Sistem Informasi Manajemen
        </p>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eye = document.getElementById('passwordEye');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            eye.classList.toggle('fa-eye', !isHidden);
            eye.classList.toggle('fa-eye-slash', isHidden);
        }
    </script>
</x-guest-layout>