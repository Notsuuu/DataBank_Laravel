@extends('layouts.guru')

@section('title', 'Log Aktivitas Saya - Panel Guru')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-emerald-600">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Log Aktivitas Saya</h2>
            <p class="mt-1 text-sm font-semibold text-slate-500">Memantau rekam jejak riwayat pembaruan berkas dan riwayat
                pendidikan yang telah Anda lakukan pada sistem.</p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">Linimasa Tindakan Personal</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-0.5">Menampilkan seluruh catatan perubahan data Anda
                        berdasarkan urutan waktu</p>
                </div>
                <span class="flex h-2 w-2 rounded-full bg-emerald-600 animate-pulse"></span>
            </div>

            <div class="mt-6 space-y-5 max-h-[450px] overflow-y-auto custom-scrollbar pr-1">
                @forelse($logs ?? [] as $log)
                    <div class="relative flex gap-4 pb-1">
                        @if (!$loop->last)
                            <span class="absolute left-4 top-8 -bottom-5 w-px bg-slate-100"></span>
                        @endif

                        @php
                            // Logika pewarnaan badge dinamis berdasarkan jenis aksi data
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
                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl border {{ $colorClass }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-xs font-bold text-slate-700">
                                    Anda memperbarui Modul <span
                                        class="text-emerald-600 font-extrabold">[{{ $log->entitas }}]</span>
                                </p>
                                <span
                                    class="text-[10px] font-bold text-slate-400 whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="mt-0.5 text-xs font-semibold text-slate-500">
                                Berhasil mengeksekusi tindakan
                                <span
                                    class="inline-block text-[9px] font-black uppercase px-1.5 py-0.5 rounded tracking-wider {{ $badgeClass }}">{{ $log->aksi }}</span>
                                pada data internal profil Anda.
                            </p>

                            @if (is_array($log->data_baru) && isset($log->data_baru['nama']))
                                <p class="mt-1 text-[11px] text-slate-400 font-bold italic">Keterangan:
                                    "{{ $log->data_baru['nama'] }}"</p>
                            @elseif(is_array($log->data_lama) && isset($log->data_lama['nama']))
                                <p class="mt-1 text-[11px] text-slate-400 font-bold italic">Keterangan Terhapus:
                                    "{{ $log->data_lama['nama'] }}"</p>
                            @endif

                            <div class="text-[9px] font-bold text-slate-400 mt-1">
                                {{ $log->created_at->format('d M Y, H:i') }} WITA
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="rounded-full bg-slate-50 p-3 border border-slate-100 text-slate-400 mb-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-400 italic">Belum ada catatan aktivitas riwayat perubahan
                            data Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
