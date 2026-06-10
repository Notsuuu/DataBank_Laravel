@extends('layouts.pimpinan')

@section('title', 'Riwayat Pendidikan - Panel Pimpinan')
@section('header', 'Riwayat Pendidikan')

@section('content')
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg relative shadow-sm">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Riwayat Pendidikan</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola data riwayat jenjang pendidikan formal Anda.</p>
        </div>
        <a href="{{ route('pimpinan.pendidikan.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg text-sm shadow-sm flex items-center justify-center gap-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Riwayat
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-8">
            @if($riwayats->count() > 0)
            <div class="relative border-l-2 border-slate-200 ml-3 md:ml-4 space-y-8">

                @foreach($riwayats as $index => $riwayat)
                <div class="relative pl-8">
                    <div class="absolute -left-[9px] top-1 h-4 w-4 rounded-full {{ $index === 0 ? 'bg-orange-500' : 'bg-slate-300' }} border-4 border-white shadow"></div>

                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2">
                        <div>
                            <span class="inline-block px-2 py-1 mb-2 text-xs font-bold {{ $index === 0 ? 'text-orange-700 bg-orange-100' : 'text-slate-700 bg-slate-100' }} rounded-md">
                                {{ $riwayat->jenjang }}
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">{{ $riwayat->institusi }}</h3>
                            <p class="text-slate-600 font-medium mt-1">{{ $riwayat->jurusan }}</p>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-sm font-bold text-slate-700">Tahun Lulus: {{ $riwayat->tahun_lulus }}</p>

                            <div class="mt-2 flex sm:justify-end gap-3 text-sm">
                                <a href="{{ route('pimpinan.pendidikan.edit', $riwayat->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Edit</a>

                                <form action="{{ route('pimpinan.pendidikan.destroy', $riwayat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus riwayat pendidikan ini?');">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition-colors">Hapus</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        @else
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">Belum ada riwayat pendidikan</h3>
                <p class="mt-1 text-sm text-slate-500">Silakan tambahkan data pendidikan terakhir Anda.</p>
            </div>
        @endif
    </div>
@endsection
