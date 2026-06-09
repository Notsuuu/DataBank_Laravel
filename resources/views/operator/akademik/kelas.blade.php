@extends('layouts.operator')

@section('header', 'Manajemen Data Kelas')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4">
        <a href="{{ route('akademik.tahun-ajaran') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">Tahun Ajaran</a>
        <a href="{{ route('akademik.kelas') }}" class="px-4 py-2.5 text-sm font-bold bg-blue-50 text-blue-700 rounded-lg border border-blue-200 shadow-sm transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-9-8h2m2 0h2m-6 4h2m2 0h2m-4-8h1m-6 0h1m2 0h1m2 0h1m-6 4h1m2 0h1m2 0h1m-6 4h1m2 0h1m2 0h1"/></svg>
            Data Kelas
        </a>
        <a href="{{ route('akademik.mapel') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">Mata Pelajaran</a>
        <a href="{{ route('akademik.rombel') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">Rombongan Belajar</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="font-extrabold text-slate-800 tracking-tight">Tambah Kelas Baru</h3>
            </div>
            
            <form action="{{ route('akademik.kelas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tingkat Kelas *</label>
                    <select name="tingkat_kelas" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="VII">Kelas VII (7)</option>
                        <option value="VIII">Kelas VIII (8)</option>
                        <option value="IX">Kelas IX (9)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Ruang/Kelas *</label>
                    <input type="text" name="nama_kelas" placeholder="Contoh: VII-A" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Wali Kelas (Opsional)</label>
                    <select name="guru_id" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->user->name ?? 'Tanpa Nama' }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Data</button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Tingkat</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Nama Kelas</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Wali Kelas</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kelas as $k)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 font-extrabold text-slate-900">{{ $k->tingkat_kelas }}</td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $k->nama_kelas }}</td>
                            <td class="px-6 py-4">
                                @if($k->waliKelas)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold text-slate-700 border border-slate-200 bg-white shadow-sm">
                                        {{ $k->waliKelas->user->name ?? 'Data Error' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs font-semibold">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('akademik.kelas.edit', $k->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs transition-colors">Edit</a>
                                    <form action="{{ route('akademik.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center py-6">
                                    <div class="text-slate-300 mb-2">
                                        <svg height="80px" width="80px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="currentColor">
                                            <g>
                                                <path d="M81.44,116.972c23.206,0,42.007-18.817,42.007-42.008c0-23.215-18.801-42.016-42.007-42.016 c-23.216,0-42.016,18.801-42.016,42.016C39.424,98.155,58.224,116.972,81.44,116.972z"></path>
                                                <path d="M224.166,245.037c0-0.856-0.142-1.673-0.251-2.498l62.748-45.541c3.942-2.867,4.83-8.411,1.963-12.362 c-1.664-2.285-4.342-3.652-7.17-3.652c-1.877,0-3.667,0.589-5.191,1.689l-62.874,45.636c-2.341-1.068-4.909-1.704-7.65-1.704 h-34.178l-8.294-47.222c-4.555-23.811-14.112-42.51-34.468-42.51h-86.3C22.146,136.873,0,159.019,0,179.383v141.203 c0,10.178,8.246,18.432,18.424,18.432c5.011,0,0,0,12.864,0l7.005,120.424c0,10.83,8.788,19.61,19.618,19.61 c8.12,0,28.398,0,39.228,0c10.83,0,19.61-8.78,19.61-19.61l9.204-238.53h0.463l5.27,23.269c1.744,11.097,11.293,19.28,22.524,19.28 h51.534C215.92,263.461,224.166,255.215,224.166,245.037z M68.026,218.861v-67.123h24.126v67.123l-12.817,15.118L68.026,218.861z"></path>
                                                <polygon points="190.326,47.47 190.326,200.869 214.452,200.869 214.452,71.595 487.874,71.595 487.874,302.131 214.452,302.131 214.452,273.113 190.326,273.113 190.326,326.256 512,326.256 512,47.47 "></polygon>
                                                <path d="M311.81,388.597c0-18.801-15.235-34.029-34.028-34.029c-18.801,0-34.036,15.228-34.036,34.029 c0,18.785,15.235,34.028,34.036,34.028C296.574,422.625,311.81,407.381,311.81,388.597z"></path>
                                                <path d="M277.781,440.853c-24.259,0-44.866,15.919-52.782,38.199h105.565 C322.648,456.771,302.04,440.853,277.781,440.853z"></path>
                                                <path d="M458.573,388.597c0-18.801-15.235-34.029-34.028-34.029c-18.801,0-34.036,15.228-34.036,34.029 c0,18.785,15.235,34.028,34.036,34.028C443.338,422.625,458.573,407.381,458.573,388.597z"></path>
                                                <path d="M424.545,440.853c-24.259,0-44.866,15.919-52.783,38.199h105.565 C469.411,456.771,448.804,440.853,424.545,440.853z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-extrabold text-slate-400 mt-2">Belum ada data Kelas.</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Gunakan formulir di sebelah kiri untuk mengisi kelas baru.</p>
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