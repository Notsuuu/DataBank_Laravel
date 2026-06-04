@extends('layouts.operator')

@section('header', 'Manajemen Data Kelas')

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
        <a href="{{ route('akademik.kelas') }}" class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Data Kelas</a>
        <a href="{{ route('akademik.mapel') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Mata Pelajaran</a>
        <a href="{{ route('akademik.rombel') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Rombongan Belajar</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
            <h3 class="font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Tambah Kelas Baru</h3>
            <form action="{{ route('akademik.kelas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tingkat Kelas</label>
                    <select name="tingkat_kelas" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        <option value="">Pilih Tingkat...</option>
                        <option value="VII">Kelas VII (7)</option>
                        <option value="VIII">Kelas VIII (8)</option>
                        <option value="IX">Kelas IX (9)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Ruang/Kelas</label>
                    <input type="text" name="nama_kelas" placeholder="Contoh: VII-A" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Wali Kelas (Opsional)</label>
                    <select name="guru_id" class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->user->name ?? 'Tanpa Nama' }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Data</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Tingkat</th>
                            <th class="px-6 py-4 font-semibold">Nama Kelas</th>
                            <th class="px-6 py-4 font-semibold">Wali Kelas</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kelas as $k)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $k->tingkat_kelas }}</td>
                            <td class="px-6 py-4 font-medium">{{ $k->nama_kelas }}</td>
                            <td class="px-6 py-4">
                                @if($k->waliKelas)
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md bg-slate-100 border border-slate-200 text-slate-700 text-xs font-medium">
                                        {{ $k->waliKelas->user->name ?? 'Data Error' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('akademik.kelas.edit', $k->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold">Edit</a>
                                    <form action="{{ route('akademik.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada data Kelas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
