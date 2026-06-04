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
                <p class="text-sm text-slate-500 mt-1">Total: {{ $siswas->count() }} siswa</p>
            </div>
            <a href="{{ route('operator.siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Siswa Baru
            </a>
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

                                <form action="{{ route('operator.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus data Siswa ini beserta seluruh relasinya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <p class="text-slate-500 font-medium text-lg">Belum ada data Siswa.</p>
                            <p class="text-slate-400 text-sm mt-1">Silakan klik "Tambah Siswa Baru" untuk memasukkan data pertama.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
