@extends('layouts.operator')

@section('header', 'Manajemen Data Pimpinan')

@section('content')
<div class="max-w-7xl mx-auto">

    @if (session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 border border-red-200 rounded-lg flex items-center gap-2 shadow-sm">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center bg-slate-50 gap-4">
            <h2 class="text-xl font-bold text-slate-800">Daftar Pimpinan SMPN 4 Palu</h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('operator.pimpinan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pimpinan
                </a>

                <a href="{{ route('operator.laporan.pimpinan.excel') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Excel
                </a>

                <a href="{{ route('operator.laporan.pimpinan.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-5 border-b border-slate-100 bg-white">
            <form action="{{ route('operator.pimpinan.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 items-end">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Cari Nama / NIP</label>
                    <input type="text" name="q" placeholder="Ketik Nama atau NIP..." value="{{ request('q') }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filter Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Semua Status --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-colors flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari & Filter
                    </button>
                    @if (request('q') || request('status') != '')
                        <a href="{{ route('operator.pimpinan.index') }}" class="rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300 transition-colors flex justify-center items-center">
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
                        <th class="px-6 py-4 font-extrabold tracking-tight w-10 text-center">No</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight">Nama & NIP</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight">Pangkat/Gol</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight">Jabatan</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight text-center">Status ASN</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight">Kontak</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight text-center">Status</th>
                        <th class="px-6 py-4 font-extrabold tracking-tight text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($para_pimpinan as $pimpinan)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        @if($pimpinan->foto)
                                            <img class="h-10 w-10 rounded-full object-cover border border-slate-200 shadow-sm" src="{{ asset('storage/' . $pimpinan->foto) }}" alt="Foto">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold shadow-sm">
                                                {{ substr($pimpinan->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 flex items-center gap-2">
                                            {{ $pimpinan->gelar_depan }} {{ $pimpinan->nama_lengkap }} {{ $pimpinan->gelar_belakang }}
                                        </div>
                                        <div class="text-[11px] font-semibold text-slate-500 mt-0.5">
                                            NIP: <span class="font-mono text-slate-700">{{ $pimpinan->nip ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-700">{{ $pimpinan->pangkat_gol ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-700">{{ $pimpinan->jabatan ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($pimpinan->status_pegawai == 'PNS')
                                    <span class="px-2.5 py-1 rounded text-xs font-bold text-blue-700 border border-blue-200 bg-blue-50">PNS</span>
                                @elseif($pimpinan->status_pegawai == 'P3K' || $pimpinan->status_pegawai == 'P3K PW')
                                    <span class="px-2.5 py-1 rounded text-xs font-bold text-emerald-700 border border-emerald-200 bg-emerald-50">{{ $pimpinan->status_pegawai }}</span>
                                @else
                                    <span class="px-2.5 py-1 rounded text-xs font-bold text-amber-700 border border-amber-200 bg-amber-50">{{ $pimpinan->status_pegawai ?? 'Honorer' }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-700">{{ $pimpinan->no_hp ?? '-' }}</div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($pimpinan->status_aktif == 'Aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold text-slate-600 border border-slate-200 bg-white shadow-sm">
                                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold text-slate-500 border border-slate-200 bg-slate-50 shadow-sm">
                                        <span class="h-2 w-2 rounded-full bg-slate-300"></span> Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('operator.pimpinan.edit', $pimpinan->id) }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Edit</a>

                                    <form action="{{ route('operator.pimpinan.destroy', $pimpinan->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menurunkan jabatan Pimpinan ini kembali menjadi Guru biasa? Data riwayatnya tidak akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-500 font-semibold">Belum ada data pimpinan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
