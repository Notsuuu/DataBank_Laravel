@extends('layouts.operator')

@section('header', 'Manajemen Rombongan Belajar (Rombel)')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4">
        <a href="{{ route('akademik.tahun-ajaran') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">Tahun Ajaran</a>
        <a href="{{ route('akademik.kelas') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">Data Kelas</a>
        <a href="{{ route('akademik.mapel') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">Mata Pelajaran</a>
        <a href="{{ route('akademik.rombel') }}" class="px-4 py-2.5 text-sm font-bold bg-blue-50 text-blue-700 rounded-lg border border-blue-200 shadow-sm transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 1024 1024" fill="currentColor"><path d="M427.84 547.52a193.6 193.6 0 1 0-193.6-193.6 193.92 193.92 0 0 0 193.6 193.6z m0-323.52a129.6 129.6 0 1 1-129.6 129.6A129.92 129.92 0 0 1 427.84 224zM822.72 937.28a32 32 0 0 0-45.44 0 32 32 0 0 0-6.72 10.56A32 32 0 0 0 768 960a32 32 0 1 0 64 0 32 32 0 0 0-2.56-12.16 32 32 0 0 0-6.72-10.56zM672 928h-128a32 32 0 0 0 0 64h128a32 32 0 0 0 0-64z"/><path d="M776.96 861.76h2.24a32 32 0 0 0 4.8-3.52l3.84-3.2a32 32 0 0 0 3.84-5.76 20.16 20.16 0 0 0 4.16-10.88 32 32 0 0 0 0-5.76 32 32 0 0 0 0-6.4 30.08 30.08 0 0 0 0-4.8 394.56 394.56 0 0 0-367.36-256A400.64 400.64 0 0 0 32 960a32 32 0 0 0 32 32h352a32 32 0 0 0 0-64H98.56a335.04 335.04 0 0 1 329.28-299.84A330.88 330.88 0 0 1 736 843.52v2.56a32 32 0 0 0 15.04 14.4h1.6a28.48 28.48 0 0 0 23.04 0zM565.76 124.8a110.08 110.08 0 1 1 123.84 179.84 32 32 0 1 0 28.8 57.28 174.08 174.08 0 1 0-196.16-284.16 32 32 0 1 0 43.52 47.04zM675.2 389.44a32 32 0 0 0-6.4 64 293.44 293.44 0 0 1 256 256H832a32 32 0 0 0 0 64h128a32 32 0 0 0 32-32 359.36 359.36 0 0 0-316.8-352z"/></svg>
            Rombongan Belajar
        </a>
    </div>

    @if(!$tahunAktif)
        <div class="bg-amber-50 text-amber-800 p-8 rounded-xl border border-amber-200 text-center shadow-sm">
            <svg class="w-16 h-16 mx-auto mb-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <h3 class="font-extrabold text-lg">Tidak Ada Tahun Ajaran Aktif</h3>
            <p class="text-sm font-semibold mt-1">Silakan aktifkan salah satu Tahun Ajaran di menu Manajemen Tahun Ajaran untuk mengelola rombel.</p>
        </div>
    @else
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-6 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-800">Tahun Ajaran: <span class="text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $tahunAktif->tahun }} | {{ $tahunAktif->semester }}</span></h3>
                <p class="text-sm font-semibold text-slate-500 mt-1">Pilih kelas untuk mengelola daftar siswa.</p>
            </div>
            <form action="{{ route('akademik.rombel') }}" method="GET" class="flex gap-2">
                <select name="kelas_id" required class="rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors w-64">
                    <option value="">-- Pilih Ruang Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->tingkat_kelas }} - {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-slate-900 transition-colors shadow-sm">Buka Kelas</button>
            </form>
        </div>

        @if($kelasId)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
                    <h3 class="font-extrabold text-slate-800 mb-5 border-b border-slate-100 pb-3">Tambah Siswa</h3>
                    <form action="{{ route('akademik.rombel.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                        <div class="mb-4">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Pilih Siswa</label>
                            <select name="siswa_id" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswas as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] font-semibold text-slate-400 mt-2">Menampilkan siswa yang belum memiliki rombel aktif.</p>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Masukkan ke Kelas</button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-extrabold text-slate-800">Daftar Anggota Kelas ({{ $rombels->count() }} Siswa)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 font-extrabold tracking-tight">NIS</th>
                                    <th class="px-6 py-4 font-extrabold tracking-tight">Nama Siswa</th>
                                    <th class="px-6 py-4 font-extrabold tracking-tight text-center">L/P</th>
                                    <th class="px-6 py-4 font-extrabold tracking-tight text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($rombels as $r)
                                <tr class="hover:bg-rose-50/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-slate-700">{{ $r->siswa->nis }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $r->siswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 rounded text-xs font-extrabold text-slate-600 border border-slate-200 bg-slate-50">{{ $r->siswa->jenis_kelamin }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('akademik.rombel.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Keluarkan siswa ini dari kelas?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs transition-colors">Keluarkan</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            <p class="text-sm font-bold text-slate-500">Belum ada siswa yang masuk kelas ini.</p>
                                        </div>
                                    </td>
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