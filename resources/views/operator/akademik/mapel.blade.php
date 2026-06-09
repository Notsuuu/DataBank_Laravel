@extends('layouts.operator')

@section('header', 'Manajemen Mata Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4">
            <a href="{{ route('akademik.tahun-ajaran') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                Tahun Ajaran
            </a>
            <a href="{{ route('akademik.kelas') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                Data Kelas
            </a>
            <a href="{{ route('akademik.mapel') }}" class="px-4 py-2.5 text-sm font-bold bg-blue-50 text-blue-700 rounded-lg border border-blue-200 shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                Mata Pelajaran
            </a>
            <a href="{{ route('akademik.rombel') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                Rombongan Belajar
            </a>
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 h-fit overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="font-extrabold text-slate-800 tracking-tight">Tambah Mapel Baru</h3>
            </div>

            <form action="{{ route('akademik.mapel.store') }}" method="POST" class="p-5">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Kode Mapel</label>
                    <input type="text" name="kode_mapel" placeholder="Contoh: MAT" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>
                <div class="mb-5">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" placeholder="Contoh: Matematika" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>
                <div class="mb-5">
                    <label  class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Kelompok (Opsional)</label>
                    <select name="kelompok_mapel" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Pilih Kelompok --</option>
                        <option value="Kelompok A (Nasional)">Kelompok A (Nasional)</option>
                        <option value="Kelompok B (Kewilayahan)">Kelompok B (Kewilayahan)</option>
                        <option value="Muatan Lokal">Muatan Lokal</option>
                        <option value="Bimbingan Konseling">Bimbingan Konseling</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Data
                </button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Kode</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Nama Mata Pelajaran</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Kelompok</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($mapels as $m)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-slate-900 text-base">{{ $m->kode_mapel }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 text-base">{{ $m->nama_mapel }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 text-base">{{ $m->kelompok_mapel ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('akademik.mapel.edit', $m->id) }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Edit</a>
                                    <form action="{{ route('akademik.mapel.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus Mapel ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        <p class="text-sm font-bold text-slate-500">Belum ada data Mata Pelajaran.</p>
                                    </div>
                                </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
