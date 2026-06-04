@extends('layouts.guru')

@section('title', 'Ringkasan Profil - Panel Guru')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-emerald-500 mb-6">
        <h2 class="text-xl font-bold text-slate-800">Selamat datang, Bapak/Ibu Guru!</h2>
        <p class="mt-2 text-slate-500">Anda dapat memantau data pribadi dan riwayat karier Anda secara mandiri di portal ini.</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        @if($user->guru)
            <div class="flex items-center gap-6 p-6 border-b border-slate-200 bg-slate-50/50">
                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-full border-4 border-white shadow-md bg-slate-200 flex items-center justify-center">
                    @if($user->guru->foto)
                        <img src="{{ asset('storage/' . $user->guru->foto) }}" alt="Foto Profil" class="h-full w-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-slate-400">{{ substr($user->guru->nama_lengkap, 0, 1) }}</span>
                    @endif
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ $user->guru->gelar_depan ? $user->guru->gelar_depan . ' ' : '' }}{{ $user->guru->nama_lengkap }}{{ $user->guru->gelar_belakang ? ', ' . $user->guru->gelar_belakang : '' }}
                    </h3>
                    <p class="text-sm font-medium text-slate-500 mt-1">NIP: {{ $user->guru->nip ?? 'Tidak ada NIP (Honorer)' }}</p>
                    <span class="mt-3 inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                        Akun Aktif
                    </span>
                </div>
            </div>

            <div class="p-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-5 border-b border-slate-100 pb-2">Informasi Biodata</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Email Terdaftar</p>
                        <p class="font-semibold text-slate-800">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-1">Nomor HP / WhatsApp</p>
                        <p class="font-semibold text-slate-800">{{ $user->guru->no_hp ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-1">Jenis Kelamin</p>
                        <p class="font-semibold text-slate-800">{{ $user->guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>

                    <div class="lg:col-span-2">
                        <p class="text-sm text-slate-500 mb-1">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold text-slate-800">
                            {{ $user->guru->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($user->guru->tanggal_lahir)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-1">Agama</p>
                        <p class="font-semibold text-slate-800">{{ $user->guru->agama }}</p>
                    </div>

                    <div class="md:col-span-2 lg:col-span-3">
                        <p class="text-sm text-slate-500 mb-1">Alamat Lengkap</p>
                        <p class="font-semibold text-slate-800">{{ $user->guru->alamat }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="p-6">
                <div class="flex items-start rounded-lg bg-amber-50 p-4 border border-amber-200">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0 text-amber-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-bold text-amber-800">Biodata Fisik Belum Tersedia</h3>
                        <p class="mt-1 text-sm text-amber-700">Akun login Anda berhasil dibuat, namun data detail profil Anda belum lengkap di sistem. Mohon hubungi Operator Sekolah untuk memperbarui data ini.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
