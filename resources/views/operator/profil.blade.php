@extends('layouts.operator')

@section('title', 'Profil Saya - Panel Operator')
@section('header', 'Profil Operator')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-xl flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-xl flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold text-sm">Password Anda berhasil diperbarui!</span>
        </div>
    @endif

    <div class="flex items-center gap-4 border-b border-slate-200/80 pb-5">
        <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200 shadow-sm shadow-blue-100/50">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Profil & Keamanan</h2>
            <p class="text-sm font-semibold text-slate-500 mt-0.5">Kelola identitas utama dan perbarui kata sandi akun operator Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <div class="lg:col-span-5 space-y-6">
            <form action="{{ route('password.update') }}" method="POST" class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 p-6 md:p-8">
                @csrf
                @method('PUT')

                <h3 class="font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Keamanan Akun
                </h3>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Password Saat Ini</label>
                        <input type="password" name="current_password" required class="w-full rounded-xl bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white transition-colors {{ $errors->updatePassword->has('current_password') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-300' }}">
                        @error('current_password', 'updatePassword')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Password Baru</label>
                        <input type="password" name="password" required class="w-full rounded-xl bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white transition-colors {{ $errors->updatePassword->has('password') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-300' }}">
                        @error('password', 'updatePassword')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white transition-colors">
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-100">
                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-2">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-7">
            <form action="{{ route('operator.profil.update') }}" method="POST" class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 p-6 md:p-8">
                @csrf
                @method('PUT')

                <h3 class="font-bold text-slate-800 mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    Identitas Operator
                </h3>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap / Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        @error('name')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Alamat Email Login <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        @error('email')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-[11px] font-semibold text-slate-400 mt-2">Email ini digunakan sebagai kredensial utama untuk mengakses panel operator.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end pt-5 border-t border-slate-100">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition-all shadow-sm shadow-blue-500/30 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
