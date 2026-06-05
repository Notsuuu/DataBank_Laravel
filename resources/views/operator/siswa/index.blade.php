@extends('layouts.operator')

@section('header', 'Manajemen Data Siswa')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Daftar Siswa Terdaftar</h3>
                <p class="text-sm text-slate-500 mt-1">Total: {{ method_exists($siswas, 'total') ? $siswas->total() : $siswas->count() }} siswa</p>
            </div>
            <a href="{{ route('operator.siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Siswa Baru
            </a>
        </div>

        <div class="p-5 border-b border-slate-100 bg-white">
            <form action="{{ route('operator.siswa.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 items-end">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Cari Nama / NISN</label>
                    <input type="text" name="q" placeholder="Ketik Nama atau NISN..." value="{{ request('q') }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filter Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Semua Kelas --</option>
                        @if(isset($semuaKelas))
                            @foreach($semuaKelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat_kelas }})
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
                        <a href="{{ route('operator.siswa.index') }}" class="rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300 transition-colors flex justify-center items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-white text-slate-700 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Profil Siswa</th>
                        <th class="px-6 py-4 font-semibold">NIS / NISN</th>
                        <th class="px-6 py-4 font-semibold text-center">L/P</th>
                        <th class="px-6 py-4 font-semibold">Wali / Kontak</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswas as $s)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                @if($s->foto)
                                    <img src="{{ asset('storage/' . $s->foto) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                        {{ substr($s->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-slate-800">{{ $s->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-500">{{ $s->tempat_lahir }}, {{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d M Y') }}</p>

                                    @if($s->rombels->isNotEmpty() && $s->rombels->first()->kelas)
                                        <p class="text-xs font-semibold text-blue-600 mt-0.5">Kelas {{ $s->rombels->first()->kelas->nama_kelas }}</p>
                                    @else
                                        <p class="text-xs font-semibold text-slate-400 italic mt-0.5">Belum ada kelas</p>
                                    @endif

                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded inline-block mb-1">{{ $s->nis }}</div>
                            <div class="font-mono text-xs text-slate-500 block">{{ $s->nisn ?? 'Tanpa NISN' }}</div>
                        </td>
                        <td class="px-6 py-3 text-center">
                            @if($s->jenis_kelamin == 'L')
                                <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded text-xs font-bold">L</span>
                            @else
                                <span class="bg-pink-100 text-pink-700 px-2.5 py-1 rounded text-xs font-bold">P</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <p class="text-sm font-medium text-slate-800">{{ $s->nama_wali ?? '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $s->no_hp_wali ?? 'Tidak ada kontak' }}</p>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('operator.siswa.edit', $s->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold">Edit</a>
                                <form action="{{ route('operator.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-slate-500">Tidak ada data ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($siswas, 'links'))
            <div class="p-4 border-t border-slate-100">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
