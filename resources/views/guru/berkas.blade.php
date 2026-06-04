@extends('layouts.guru')

@section('title', 'Pembaruan Berkas - Panel Guru')

@section('content')
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Pembaruan Berkas Administrasi</h2>
        <p class="text-sm text-slate-500 mt-1">Unggah salinan dokumen fisik (PDF/JPG) Anda untuk melengkapi arsip kepegawaian sekolah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @php $adaKtp = isset($berkas['ktp']); @endphp
        <div class="rounded-xl border {{ $adaKtp ? 'border-emerald-200 bg-emerald-50/30' : 'border-rose-200 bg-rose-50/30' }} p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-bold text-slate-800">Scan KTP Asli</h3>
                    <span class="inline-flex items-center rounded-full {{ $adaKtp ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-rose-100 text-rose-700 border-rose-200' }} px-2.5 py-0.5 text-xs font-semibold border">
                        {{ $adaKtp ? 'Sudah Diunggah' : 'Belum Diunggah' }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mb-2">Format: JPG/PNG/PDF (Max 5MB).</p>

                @if($adaKtp)
                    <a href="{{ asset('storage/' . $berkas['ktp']) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                        Lihat Dokumen
                    </a>
                @endif
            </div>

            <form action="{{ route('guru.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-4 {{ $adaKtp ? 'border-t border-emerald-100' : '' }}">
                @csrf
                <input type="hidden" name="jenis_berkas" value="ktp">
                <p class="text-xs text-slate-500 mb-2 font-medium">{{ $adaKtp ? 'Perbarui Dokumen (Opsional)' : 'Pilih File untuk Diunggah' }}</p>
                <div class="flex gap-2">
                    <input type="file" name="file_berkas" required class="block w-full text-sm text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-slate-700 file:border file:border-slate-200 hover:file:bg-slate-50 cursor-pointer">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-3 rounded-md text-xs transition-colors flex-shrink-0">
                        {{ $adaKtp ? 'Update' : 'Unggah' }}
                    </button>
                </div>
            </form>
        </div>

        @php $adaIjazah = isset($berkas['ijazah']); @endphp
        <div class="rounded-xl border {{ $adaIjazah ? 'border-emerald-200 bg-emerald-50/30' : 'border-rose-200 bg-rose-50/30' }} p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-bold text-slate-800">Ijazah Terakhir</h3>
                    <span class="inline-flex items-center rounded-full {{ $adaIjazah ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-rose-100 text-rose-700 border-rose-200' }} px-2.5 py-0.5 text-xs font-semibold border">
                        {{ $adaIjazah ? 'Sudah Diunggah' : 'Belum Diunggah' }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mb-2">Format: JPG/PNG/PDF (Max 5MB).</p>

                @if($adaIjazah)
                    <a href="{{ asset('storage/' . $berkas['ijazah']) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                        Lihat Dokumen
                    </a>
                @endif
            </div>

            <form action="{{ route('guru.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-4 {{ $adaIjazah ? 'border-t border-emerald-100' : '' }}">
                @csrf
                <input type="hidden" name="jenis_berkas" value="ijazah">
                <p class="text-xs text-slate-500 mb-2 font-medium">{{ $adaIjazah ? 'Perbarui Dokumen (Opsional)' : 'Pilih File untuk Diunggah' }}</p>
                <div class="flex gap-2">
                    <input type="file" name="file_berkas" required class="block w-full text-sm text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-slate-700 file:border file:border-slate-200 hover:file:bg-slate-50 cursor-pointer">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-3 rounded-md text-xs transition-colors flex-shrink-0">
                        {{ $adaIjazah ? 'Update' : 'Unggah' }}
                    </button>
                </div>
            </form>
        </div>

        @php $adaSK = isset($berkas['sk']); @endphp
        <div class="rounded-xl border {{ $adaSK ? 'border-emerald-200 bg-emerald-50/30' : 'border-rose-200 bg-rose-50/30' }} p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-bold text-slate-800">SK Pengangkatan</h3>
                    <span class="inline-flex items-center rounded-full {{ $adaSK ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-rose-100 text-rose-700 border-rose-200' }} px-2.5 py-0.5 text-xs font-semibold border">
                        {{ $adaSK ? 'Sudah Diunggah' : 'Belum Diunggah' }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mb-2">Wajib bagi Guru PNS/PPPK (Max 5MB).</p>

                @if($adaSK)
                    <a href="{{ asset('storage/' . $berkas['sk']) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                        Lihat Dokumen
                    </a>
                @endif
            </div>

            <form action="{{ route('guru.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-4 {{ $adaSK ? 'border-t border-emerald-100' : '' }}">
                @csrf
                <input type="hidden" name="jenis_berkas" value="sk">
                <p class="text-xs text-slate-500 mb-2 font-medium">{{ $adaSK ? 'Perbarui Dokumen (Opsional)' : 'Pilih File untuk Diunggah' }}</p>
                <div class="flex gap-2">
                    <input type="file" name="file_berkas" required class="block w-full text-sm text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-slate-700 file:border file:border-slate-200 hover:file:bg-slate-50 cursor-pointer">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-3 rounded-md text-xs transition-colors flex-shrink-0">
                        {{ $adaSK ? 'Update' : 'Unggah' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
