@extends('layouts.operator')

@section('header', 'Manajemen Mata Pelajaran')

@section('content')
<div class="max-w-6xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex space-x-2 border-b border-slate-200 pb-2">
        <a href="{{ route('akademik.tahun-ajaran') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Tahun Ajaran</a>
        <a href="{{ route('akademik.kelas') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Data Kelas</a>
        <a href="{{ route('akademik.mapel') }}" class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Mata Pelajaran</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
            <h3 class="font-bold text-slate-800 mb-4">Tambah Mapel Baru</h3>
            <form action="{{ route('akademik.mapel.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode Mapel</label>
                    <input type="text" name="kode_mapel" placeholder="Contoh: MAT, BING, IPA" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm uppercase">
                    <p class="text-xs text-slate-500 mt-1">Gunakan singkatan unik (Maks 20 huruf).</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" placeholder="Contoh: Matematika" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kelompok Mapel (Opsional)</label>
                    <select name="kelompok_mapel" class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        <option value="">-- Pilih Kelompok --</option>
                        <option value="Kelompok A (Nasional)">Kelompok A (Nasional)</option>
                        <option value="Kelompok B (Kewilayahan)">Kelompok B (Kewilayahan)</option>
                        <option value="Muatan Lokal">Muatan Lokal</option>
                        <option value="Bimbingan Konseling">Bimbingan Konseling</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Mapel</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold w-24">Kode</th>
                        <th class="px-6 py-4 font-semibold">Nama Mata Pelajaran</th>
                        <th class="px-6 py-4 font-semibold">Kelompok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mapels as $m)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800"><span class="bg-slate-100 text-slate-700 px-2 py-1 rounded text-xs font-mono border border-slate-200">{{ $m->kode_mapel }}</span></td>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $m->nama_mapel }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-500 font-medium">{{ $m->kelompok_mapel ?? '-' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <p class="text-slate-500 font-medium">Belum ada data Mata Pelajaran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
