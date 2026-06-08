<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Konfirmasi Keamanan</h2>
    </div>

    <div class="mb-6 text-sm font-medium text-slate-500 text-center leading-relaxed">
        Ini adalah area aman dari sistem. Harap konfirmasi kata sandi Anda terlebih dahulu sebelum melanjutkan tindakan ini.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="flex items-center justify-end mt-8">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Konfirmasi
            </button>
        </div>
    </form>
</x-guest-layout>