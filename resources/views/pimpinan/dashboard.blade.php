@extends('layouts.pimpinan')

@section('header', 'Ringkasan Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- BANNER SELAMAT DATANG -->
    <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl shadow-lg shadow-orange-500/20 overflow-hidden relative border border-orange-500/20 p-8">
        <h2 class="text-3xl font-black text-white tracking-tight">Selamat datang, Pimpinan!</h2>
        <p class="mt-2 text-orange-50 font-medium max-w-xl">Monitoring data sekolah secara real-time dan tinjau aktivitas operasional staf Anda di bawah ini.</p>
    </div>

    <!-- STATISTIK UTAMA -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Guru</p>
            <p class="text-4xl font-black text-slate-800 mt-2">{{ $totalGuru }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Siswa</p>
            <p class="text-4xl font-black text-slate-800 mt-2">{{ $totalSiswa }}</p>
        </div>
        <!-- Kelengkapan Berkas Progress -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-center mb-2">
                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Kelengkapan Berkas Guru</p>
                <span class="text-xs font-black text-orange-600">{{ number_format($persenKelengkapan, 0) }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2.5">
                <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ $persenKelengkapan }}%"></div>
            </div>
        </div>
    </div>

    <!-- MONITORING AKTIVITAS & QUICK ACTIONS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Riwayat Aktivitas (Span 2) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="font-black text-slate-800 mb-6">Aktivitas Terbaru</h3>
            <div class="space-y-6">
                @foreach($logs as $log)
                <div class="flex gap-4">
                    <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $log->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $log->aksi }} pada modul {{ $log->entitas }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions (Span 1) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="font-black text-slate-800 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="#" class="block w-full p-4 rounded-xl border border-slate-100 hover:border-orange-500 hover:bg-orange-50 transition-all font-bold text-slate-700 text-sm">
                    Unduh Rekap Guru (Excel)
                </a>
                <a href="#" class="block w-full p-4 rounded-xl border border-slate-100 hover:border-orange-500 hover:bg-orange-50 transition-all font-bold text-slate-700 text-sm">
                    Unduh Data Siswa (Excel)
                </a>
            </div>
        </div>
    </div>
</div>
@endsection