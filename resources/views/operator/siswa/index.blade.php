@extends('layouts.operator')

@section('header', 'Manajemen Data Siswa')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-rose-50 text-rose-700 px-4 py-3 border border-rose-200 rounded-lg flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    @error('file_excel')
        <div class="mb-6 bg-rose-50 text-rose-700 px-4 py-3 border border-rose-200 rounded-lg flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <span class="font-bold text-sm">{{ $message }}</span>
        </div>
    @enderror

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:justify-between md:items-center bg-slate-50 gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Daftar Siswa Terdaftar</h2>
                <p class="text-sm font-semibold text-slate-500 mt-0.5">Total keseluruhan: <span class="text-blue-600 font-extrabold">{{ method_exists($siswas, 'total') ? $siswas->total() : $siswas->count() }}</span> siswa</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('operator.siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Siswa Baru
                </a>

                <a href="{{ route('operator.laporan.siswa.excel') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Excel
                </a>

                <a href="{{ route('operator.laporan.siswa.pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-5 bg-white border-b border-slate-100">
            <form action="{{ route('operator.siswa.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
                @csrf
                <div class="flex-1 w-full">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Import Data Siswa Massal</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 transition-colors">
                    <p class="mt-1.5 text-[11px] font-semibold text-slate-400">Format didukung: .xlsx, .csv. Maksimal: 5MB.</p>
                </div>
                <button type="submit" class="mt-6 sm:mt-0 bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-6 rounded-lg text-sm shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Upload & Import
                </button>
            </form>
        </div>

        <div class="p-5 border-b border-slate-100 bg-white">
            <form action="{{ route('operator.siswa.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 items-end">
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Cari Nama / NISN</label>
                    <input type="text" name="q" placeholder="Ketik Nama atau NISN..." value="{{ request('q') }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Filter Ruang Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Semua Kelas --</option>
                        @if(isset($semuaKelas))
                            @foreach($semuaKelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                    Kelas {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat_kelas }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-colors flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari Data
                    </button>
                    @if(request('q') || request('kelas'))
                        <a href="{{ route('operator.siswa.index') }}" class="rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300 transition-colors flex justify-center items-center shadow-sm">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-extrabold tracking-tight">Profil Siswa</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight">NIS / NISN</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight text-center">L/P</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight">Orang Tua / Kontak</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswas as $s)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 flex-shrink-0">
                                    @if($s->foto)
                                        <img src="{{ asset('storage/' . $s->foto) }}" class="h-10 w-10 rounded-full object-cover border border-slate-200 shadow-sm" alt="Foto">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-slate-100 border border-slate-200 shadow-sm flex items-center justify-center text-slate-600 font-bold">
                                            {{ substr($s->nama_lengkap, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="font-bold text-slate-900">{{ $s->nama_lengkap }}</div>
                                    <div class="text-[11px] font-semibold text-slate-500 mt-0.5">
                                        {{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d M Y') : '-' }}
                                    </div>

                                    @if($s->kelas)
                                        <div class="inline-flex items-center gap-1 text-[11px] font-extrabold text-blue-700 bg-blue-50 border border-blue-100 px-1.5 py-0.5 rounded mt-1 shadow-sm">
                                            Kelas {{ $s->kelas->nama_kelas }}
                                        </div>
                                    @else
                                        <div class="text-[11px] font-semibold text-slate-400 mt-1 italic">
                                            Belum terdaftar di kelas
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-mono text-xs font-bold text-slate-700 bg-white border border-slate-200 shadow-sm px-2 py-0.5 rounded inline-block mb-1">
                                {{ $s->nis ?? '-' }}
                            </div>
                            <div class="font-mono text-xs font-semibold text-slate-500 block">
                                NISN: <span class="font-bold text-slate-600">{{ $s->nisn ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($s->jenis_kelamin == 'L')
                                <span class="px-2.5 py-1 rounded text-xs font-extrabold text-slate-600 border border-slate-200 bg-slate-50 shadow-sm">L</span>
                            @else
                                <span class="px-2.5 py-1 rounded text-xs font-extrabold text-slate-600 border border-slate-200 bg-slate-50 shadow-sm">P</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-xs font-extrabold text-slate-800">
                                {{ $s->nama_ayah ?? $s->nama_ibu ?? $s->nama_wali ?? 'Data tidak ada' }}
                            </div>
                            <div class="text-[11px] font-semibold text-slate-500 mt-0.5">
                                HP: {{ $s->no_hp_siswa ?? $s->no_hp_wali ?? 'Tidak ada kontak' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('operator.siswa.edit', $s->id) }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Edit</a>

                                <form action="{{ route('operator.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus data Siswa ini secara permanen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p class="text-sm font-bold text-slate-500">Data siswa tidak ditemukan di sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($siswas, 'links'))
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection