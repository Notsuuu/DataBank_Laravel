@extends('layouts.operator')

@section('header', 'Manajemen Rombongan Belajar (Rombel)')

@section('content')
<div class="max-w-6xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 rounded-lg border border-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-6 flex space-x-2 border-b border-slate-200 pb-2">
        <a href="{{ route('akademik.tahun-ajaran') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Tahun Ajaran</a>
        <a href="{{ route('akademik.kelas') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Data Kelas</a>
        <a href="{{ route('akademik.mapel') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Mata Pelajaran</a>
        <a href="{{ route('akademik.rombel') }}" class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Rombongan Belajar</a>
    </div>

    @if(!$tahunAktif)
        <div class="bg-amber-50 text-amber-700 p-6 rounded-xl border border-amber-200 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <h3 class="font-bold text-lg">Tidak Ada Tahun Ajaran Aktif</h3>
            <p class="text-sm mt-1">Silakan aktifkan salah satu Tahun Ajaran di menu Manajemen Tahun Ajaran terlebih dahulu sebelum mengatur Rombel.</p>
        </div>
    @else

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800">Tahun Ajaran Berjalan: <span class="text-blue-600">{{ $tahunAktif->tahun }} ({{ $tahunAktif->semester }})</span></h3>
                    <p class="text-sm text-slate-500 mt-1">Pilih kelas untuk mengatur siswa di dalamnya.</p>
                </div>

                <form action="{{ route('akademik.rombel') }}" method="GET" class="flex gap-2">
                    <select name="kelas_id" required class="rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm w-48">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->tingkat_kelas }} - {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-slate-900 transition-colors">Buka Kelas</button>
                </form>
            </div>
        </div>

        @if($kelasId)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
                    <h3 class="font-bold text-slate-800 mb-4">Tambah Siswa ke Kelas</h3>
                    <form action="{{ route('akademik.rombel.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Cari Siswa</label>
                            <select name="siswa_id" required class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswas as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-2">Pilih siswa yang belum memiliki kelas di tahun ajaran ini.</p>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Masukkan ke Kelas</button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-bold text-slate-800">Daftar Anggota Kelas ({{ $rombels->count() }} Siswa)</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-white text-slate-700 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">NIS</th>
                                    <th class="px-6 py-3 font-semibold">Nama Siswa</th>
                                    <th class="px-6 py-3 font-semibold text-center">L/P</th>
                                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($rombels as $r)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3 font-mono text-xs font-bold text-slate-700">{{ $r->siswa->nis }}</td>
                                    <td class="px-6 py-3 font-medium text-slate-900">{{ $r->siswa->nama_lengkap }}</td>
                                    <td class="px-6 py-3 text-center">{{ $r->siswa->jenis_kelamin }}</td>
                                    <td class="px-6 py-3 text-right">
                                        <form action="{{ route('akademik.rombel.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Keluarkan siswa ini dari kelas?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold px-2">Keluarkan</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-medium">Belum ada siswa di kelas ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    @endif
</div>
@endsection
