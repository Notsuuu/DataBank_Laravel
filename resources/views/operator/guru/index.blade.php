@extends('layouts.operator')

@section('header', 'Manajemen Data Guru')

@section('content')
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-white">
            <h2 class="text-xl font-bold text-slate-800">Daftar Guru SMPN 4 Palu</h2>
            <a href="{{ route('operator.guru.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm shadow-sm transition-colors">
                + Tambah Guru Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">NIP</th>
                        <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                        <th class="px-6 py-4 font-semibold text-center">L/P</th>
                        <th class="px-6 py-4 font-semibold text-center">No HP</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($gurus as $guru)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs">{{ $guru->nip ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}</td>
                        <td class="px-6 py-4 text-center">{{ $guru->jenis_kelamin }}</td>
                        <td class="px-6 py-4 text-center">{{ $guru->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('operator.guru.edit', $guru->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Edit</a>

                                <form action="{{ route('operator.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus data Guru ini beserta akun loginnya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic">Belum ada data guru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
