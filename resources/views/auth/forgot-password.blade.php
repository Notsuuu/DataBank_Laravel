<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Lupa Kata Sandi?</h2>
    </div>

    <div class="mb-6 text-sm font-medium text-slate-500 text-center leading-relaxed">
        Tidak masalah. Cukup masukkan alamat email yang terdaftar, dan sistem akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
    </div>

    <x-auth-session-status class="mb-4 text-green-600 font-medium text-sm text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="block text-sm font-bold text-slate-700">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 rounded-md">
                &larr; Kembali
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Kirim Tautan Reset
            </button>
        </div>
    </form>
</x-guest-layout>