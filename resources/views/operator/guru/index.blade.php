@extends('layouts.operator')

@section('header', 'Manajemen Data Guru')

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
    
    @error('file_excel')
        <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 border border-red-200 rounded-lg flex items-center gap-2 shadow-sm">
            <span class="font-medium">{{ $message }}</span>
        </div>
    @enderror

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h2 class="text-xl font-bold text-slate-800">Daftar Guru SMPN 4 Palu</h2>
            <div class="flex gap-2">
                <a href="{{ route('operator.guru.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Guru Baru
                </a>
                
                <a href="{{ route('operator.laporan.guru.excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Excel
                </a>
            </div>
        </div>

        <div class="p-5 bg-white border-b border-slate-100">
            <form action="{{ route('operator.guru.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
                @csrf
                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Import Data Guru Massal</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 transition-colors">
                    <p class="mt-1.5 text-xs text-slate-500">Format yang didukung: .xlsx, .csv. Maksimal: 5MB.</p>
                </div>
                <button type="submit" class="mt-6 sm:mt-0 bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-6 rounded-lg text-sm shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Upload & Import
                </button>
            </form>
        </div>

        <div class="p-5 border-b border-slate-100 bg-white">
            <form action="{{ route('operator.guru.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4 items-end">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Cari Nama / NIP</label>
                    <input type="text" name="q" placeholder="Ketik Nama atau NIP..." value="{{ request('q') }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filter Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Semua Status --</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filter Tingkat Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Semua Tingkat --</option>
                        <option value="VII" {{ ($tingkatKelas ?? '') == 'VII' ? 'selected' : '' }}>Kelas 7</option>
                        <option value="VIII" {{ ($tingkatKelas ?? '') == 'VIII' ? 'selected' : '' }}>Kelas 8</option>
                        <option value="IX" {{ ($tingkatKelas ?? '') == 'IX' ? 'selected' : '' }}>Kelas 9</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-colors flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari & Filter
                    </button>
                    @if (request('q') || request('status') || request('kelas'))
                        <a href="{{ route('operator.guru.index') }}" class="rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300 transition-colors flex justify-center items-center">
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
                        <th class="px-6 py-4 font-semibold">NIP</th>
                        <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                        <th class="px-6 py-4 font-semibold text-center">L/P</th>
                        <th class="px-6 py-4 font-semibold text-center">No HP</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($para_guru as $guru)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs">{{ $guru->nip ?? '-' }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($guru->jenis_kelamin == 'L')
                                    <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded text-xs font-bold">L</span>
                                @elseif($guru->jenis_kelamin == 'P')
                                    <span class="bg-pink-100 text-pink-700 px-2.5 py-1 rounded text-xs font-bold">P</span>
                                @else
                                    {{ $guru->jenis_kelamin }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $guru->no_hp ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('operator.guru.edit', $guru->id) }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Edit</a>

                                    <form action="{{ route('operator.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus data Guru ini beserta akun loginnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-500">Data guru tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection