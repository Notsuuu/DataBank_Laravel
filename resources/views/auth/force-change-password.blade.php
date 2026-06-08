<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mx-auto w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4 shadow-sm">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Wajib Ganti Kata Sandi</h2>
        <p class="text-sm font-medium text-slate-500 mt-2 leading-relaxed">
            Demi keamanan sistem akademik, Anda diwajibkan untuk mengganti kata sandi bawaan dengan kata sandi baru yang lebih aman.
        </p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 border border-red-200 rounded-lg text-sm font-bold text-center shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.force.update') }}">
        @csrf

        <div>
            <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi Baru</label>
            <input id="password" type="password" name="password" required autofocus
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="mt-6">
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required 
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="flex items-center justify-between mt-8 border-t border-slate-200 pt-6">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm font-bold text-slate-500 hover:text-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md px-2 py-1">
                Batalkan & Keluar
            </a>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan & Lanjutkan
            </button>
        </div>
    </form>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</x-guest-layout>