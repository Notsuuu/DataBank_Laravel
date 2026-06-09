@extends('layouts.guru')

@section('title', 'Dashboard Utama - Panel Guru')

@section('content')
<div class="space-y-6">

    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl shadow-md shadow-emerald-500/10 overflow-hidden relative border border-emerald-500/20">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        
        <div class="relative p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-white flex-1 text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-black tracking-tight mb-2">
                    Selamat datang kembali, {{ $user->guru->gelar_depan ?? '' }} {{ $user->name }} {{ $user->guru->gelar_belakang ?? '' }}!
                </h2>
                <p class="text-emerald-50 font-medium text-sm md:text-base max-w-2xl mx-auto md:mx-0 opacity-90">
                    Kelola biodata, perbarui riwayat pendidikan, dan pastikan kelengkapan berkas administrasimu di sini.
                </p>
            </div>
            <div class="flex-shrink-0">
                @if($user->guru->foto)
                    <img src="{{ asset('storage/' . $user->guru->foto) }}" class="h-24 w-24 rounded-full object-cover border-4 border-white/20 shadow-xl" alt="Foto Profil">
                @else
                    <div class="h-24 w-24 rounded-full bg-white/10 border-4 border-white/20 flex items-center justify-center text-3xl font-black text-white shadow-xl backdrop-blur-sm">
                        {{ Str::upper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm shadow-slate-200/50 border border-slate-200/80 flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex items-start justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center border border-slate-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Kepegawaian</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Keaktifan</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-800">{{ $user->guru->status_aktif == 'Aktif' ? 'Aktif Mengajar' : 'Nonaktif' }}</h3>
                </div>
                <p class="text-xs font-semibold text-slate-500 mt-2">NIP: <span class="text-slate-800 font-bold">{{ $user->guru->nip ?? 'Guru Honorer (Tanpa NIP)' }}</span></p>
            </div>
        </div>

        @php
            $berkasDiisi = 0;
            if($user->guru->file_ktp) $berkasDiisi++;
            if($user->guru->file_ijazah) $berkasDiisi++;
            if($user->guru->file_sk) $berkasDiisi++;
            $persentase = round(($berkasDiisi / 3) * 100);
        @endphp
        <div class="bg-white p-6 rounded-xl shadow-sm shadow-slate-200/50 border border-slate-200/80 flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex items-start justify-between mb-4">
                <div class="h-10 w-10 rounded-xl {{ $persentase == 100 ? 'bg-teal-50 text-teal-600 border-teal-200' : 'bg-amber-50 text-amber-600 border-amber-200' }} flex items-center justify-center border">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Dokumen</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kelengkapan Berkas</p>
                <div class="flex items-baseline gap-2 mb-3">
                    <h3 class="text-2xl font-black {{ $persentase == 100 ? 'text-teal-600' : 'text-amber-600' }}">{{ $persentase }}%</h3>
                    <span class="text-xs font-bold text-slate-500">({{ $berkasDiisi }} dari 3 Berkas)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-1 overflow-hidden">
                    <div class="h-1.5 rounded-full transition-all duration-1000 {{ $persentase == 100 ? 'bg-teal-500' : 'bg-amber-500' }}" style="width: {{ $persentase }}%"></div>
                </div>
                @if($persentase < 100)
                    <p class="text-[10px] font-bold text-amber-600 mt-2">Segera lengkapi berkas di menu Pembaruan Berkas.</p>
                @else
                    <p class="text-[10px] font-bold text-teal-600 mt-2">Semua berkas wajib telah terunggah.</p>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm shadow-slate-200/50 border border-slate-200/80 flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex items-start justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Akademik</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Riwayat Pendidikan</p>
                <div class="flex items-baseline gap-2">
                    @php $jumlahPendidikan = \App\Models\RiwayatPendidikan::where('guru_id', $user->guru->id)->count(); @endphp
                    <h3 class="text-2xl font-black text-slate-800">{{ $jumlahPendidikan }}</h3>
                    <span class="text-sm font-bold text-slate-500">Gelar Terdata</span>
                </div>
                <div class="mt-2 flex gap-2">
                    <a href="{{ route('guru.pendidikan') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition-colors">
                        Lihat Rincian <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-sm shadow-slate-200/50 border border-slate-200/80 overflow-hidden mt-6">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-extrabold text-slate-800 tracking-tight">Aksi Cepat</h3>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <a href="{{ route('guru.berkas') }}" class="group flex items-center p-4 rounded-xl border border-slate-100 bg-slate-50 hover:border-teal-300 hover:bg-teal-50 hover:shadow-sm transition-all duration-200">
                <div class="h-12 w-12 rounded-xl bg-white text-teal-600 flex items-center justify-center mr-4 border border-slate-200 group-hover:border-teal-200 transition-colors shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-teal-700 transition-colors">Pembaruan Berkas</h4>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Upload KTP, Ijazah & SK</p>
                </div>
            </a>

            <a href="{{ route('guru.pendidikan') }}" class="group flex items-center p-4 rounded-xl border border-slate-100 bg-slate-50 hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-sm transition-all duration-200">
                <div class="h-12 w-12 rounded-xl bg-white text-emerald-600 flex items-center justify-center mr-4 border border-slate-200 group-hover:border-emerald-200 transition-colors shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">Riwayat Pendidikan</h4>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Tambah data gelar akademik</p>
                </div>
            </a>

            <a href="{{ route('guru.log-aktivitas') }}" class="group flex items-center p-4 rounded-xl border border-slate-100 bg-slate-50 hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-sm transition-all duration-200">
                <div class="h-12 w-12 rounded-xl bg-white text-emerald-600 flex items-center justify-center mr-4 border border-slate-200 group-hover:border-emerald-200 transition-colors shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">Log Aktivitas Saya</h4>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Pantau riwayat aktivitasmu</p>
                </div>
            </a>

        </div>
    </div>

</div>
@endsection 