@extends('layouts.operator')

@section('header', 'Ringkasan Sistem')

@section('content')
    <div class="space-y-6">
        <div
            class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-blue-600 animate-[fadeIn_0.3s_ease-out]">
            <h2 class="text-xl font-bold text-slate-800">Selamat datang, Operator!</h2>
            <p class="mt-2 text-sm font-medium text-slate-500">Gunakan menu di sebelah kiri untuk mengelola Bank Data SMPN 4
                Palu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 group">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Guru</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1 tracking-tight">{{ $totalGuru ?? 0 }}</p>
                </div>
                <div
                    class="h-11 w-11 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black text-base border border-blue-100/70 transition-colors duration-300 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 shadow-sm">
                    G
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 group">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1 tracking-tight">{{ $totalSiswa ?? 0 }}</p>
                </div>
                <div
                    class="h-11 w-11 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black text-base border border-indigo-100/70 transition-colors duration-300 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-600 shadow-sm">
                    S
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 group">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rombongan Belajar</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1 tracking-tight">{{ $totalKelas ?? 0 }}</p>
                </div>
                <div
                    class="h-11 w-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-black text-base border border-emerald-100/70 transition-colors duration-300 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 shadow-sm">
                    K
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">Radar Monitor Aktivitas Data</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-0.5">Menampilkan jejak operasi manipulasi data terbaru
                        yang terjadi di dalam aplikasi secara berkala</p>
                </div>
                <span class="flex h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
            </div>

            <div class="mt-6 space-y-5 max-h-[350px] overflow-y-auto custom-scrollbar pr-1">
                @forelse($logs ?? [] as $log)
                    <div class="relative flex gap-4 pb-1">
                        @if (!$loop->last)
                            <span class="absolute left-4 top-8 -bottom-5 w-px bg-slate-100"></span>
                        @endif

                        @php
                            $colorClass = 'bg-slate-50 border-slate-200 text-slate-600';
                            $badgeClass = 'bg-slate-100 text-slate-700';

                            if (strtoupper($log->aksi) === 'CREATE') {
                                $colorClass = 'bg-blue-50 border-blue-100 text-blue-600';
                                $badgeClass = 'bg-blue-100 text-blue-800';
                            } elseif (strtoupper($log->aksi) === 'UPDATE') {
                                $colorClass = 'bg-amber-50 border-amber-100 text-amber-600';
                                $badgeClass = 'bg-amber-100 text-amber-800';
                            } elseif (strtoupper($log->aksi) === 'DELETE') {
                                $colorClass = 'bg-rose-50 border-rose-100 text-rose-600';
                                $badgeClass = 'bg-rose-100 text-rose-800';
                            }
                        @endphp

                        <div
                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl border shadow-sm {{ $colorClass }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-xs font-bold text-slate-700">
                                    <span class="font-extrabold text-blue-600">{{ $log->user->name ?? 'Sistem' }}</span>
                                    memproses Modul <span class="text-slate-900 font-extrabold">[{{ $log->entitas }}]</span>
                                </p>
                                <span
                                    class="text-[10px] font-bold text-slate-400 whitespace-nowrap bg-slate-50 border border-slate-100 rounded-md px-1.5 py-0.5 shadow-sm">{{ $log->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="mt-0.5 text-xs font-semibold text-slate-500">
                                Mengeksekusi operasi data berbentuk
                                <span
                                    class="inline-block text-[9px] font-black uppercase px-1.5 py-0.5 rounded tracking-wider {{ $badgeClass }}">{{ $log->aksi }}</span>
                                secara permanen.
                            </p>

                            @if (is_array($log->data_baru) && isset($log->data_baru['nama']))
                                <p class="mt-1 text-[11px] text-slate-400 font-bold italic">Nama Terkait:
                                    "{{ $log->data_baru['nama'] }}"</p>
                            @elseif(is_array($log->data_lama) && isset($log->data_lama['nama']))
                                <p class="mt-1 text-[11px] text-rose-400 font-bold italic">Nama Terhapus:
                                    "{{ $log->data_lama['nama'] }}"</p>
                            @endif

                            <div class="text-[9px] font-bold text-slate-400 mt-1">
                                {{ $log->created_at->format('d M Y, H:i') }} WITA
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <p class="text-xs font-bold text-slate-400 italic">Belum ada rekaman log riwayat manipulasi data
                            dari operator maupun guru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
