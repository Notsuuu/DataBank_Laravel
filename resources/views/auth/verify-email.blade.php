<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Atur Ulang Kata Sandi</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">Silakan masukkan kata sandi baru Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-bold text-slate-700">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" 
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="mt-6">
            <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="mt-6">
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="block mt-2 w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" />
            
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 font-medium" />
        </div>

        <div class="flex items-center justify-end mt-8">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Kata Sandi Baru
            </button>
        </div>
    </form>
</x-guest-layout>