<x-guest-layout>
    <div class="text-center mb-8">
        <a href="/" class="flex items-center justify-center mb-4">
            <x-application-logo class="w-20 h-20 text-pink-700 fill-current" />
        </a>
        <h2 class="text-3xl font-extrabold text-gray-900">SIM KUD GAMA</h2>
        <p class="mt-2 text-sm text-gray-600">
            Sistem Informasi Manajemen KUD Gajah Mada <br>
            Desa Telagasari, Kab. Kotabaru
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input type="email" name="email" id="email" value="{{ old('email') }}"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input type="password" name="password" id="password"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember"
                    class="w-4 h-4 text-pink-600 border-gray-300 rounded form-checkbox focus:ring-pink-500">
                <label for="remember" class="block ml-2 text-sm text-gray-700">
                    {{ __('Ingat Saya') }}
                </label>
            </div>

            <div class="text-sm">
                @if (Route::has('password.request'))
                    <a class="font-medium text-pink-700 hover:text-pink-600 hover:underline"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="pt-2 mt-6">
            <x-primary-button
                class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-pink-700 border border-transparent rounded-md shadow-sm hover:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                {{ __('Masuk ke Sistem') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
