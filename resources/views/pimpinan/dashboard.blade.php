@extends('layouts.pimpinan')

@section('header', 'Executive Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-blue-600">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Selamat datang, Pimpinan!</h2>
            <p class="mt-1 text-sm font-semibold text-slate-500">Pantau grafik statistik dan monitoring data sekolah secara
                real-time di sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Guru</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalGuru }}</p>
                </div>
                <div
                    class="h-11 w-11 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-extrabold text-sm border border-blue-100">
                    G
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalSiswa }}</p>
                </div>
                <div
                    class="h-11 w-11 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-extrabold text-sm border border-blue-100">
                    S
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">Riwayat Aktivitas Sistem</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-0.5">Daftar rekam jejak pekerjaan administratif yang
                        telah dilakukan di sistem</p>
                </div>
                <span class="flex h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
            </div>

            <div class="mt-6 space-y-5 max-h-[350px] overflow-y-auto custom-scrollbar pr-1">
                @forelse($logs ?? [] as $log)
                    <div class="relative flex gap-4 pb-1">
                        @if (!$loop->last)
                            <span class="absolute left-4 top-8 -bottom-5 w-px bg-slate-100"></span>
                        @endif

                        <div
                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl border bg-blue-50 border-blue-100 text-blue-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-xs font-bold text-slate-700">
                                    <span class="font-extrabold text-slate-900">{{ $log->user->name ?? 'Sistem' }}</span>
                                    memperbarui Modul <span class="text-blue-600 font-extrabold">{{ $log->entitas }}</span>
                                </p>
                                <span
                                    class="text-[10px] font-bold text-slate-400 whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-0.5 text-xs font-semibold text-slate-500">
                                Berhasil mengeksekusi tindakan
                                <span
                                    class="inline-block text-[9px] font-black uppercase px-1.5 py-0.5 rounded tracking-wider bg-blue-100 text-blue-800">{{ $log->aksi }}</span>
                                pada database internal sekolah.
                            </p>
                            <div class="text-[9px] font-bold text-slate-400 mt-1">
                                {{ $log->created_at->format('d M Y, H:i') }} WITA
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <p class="text-xs font-bold text-slate-400 italic">Belum ada rekaman jejak aktivitas operasional
                            data sekolah.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
