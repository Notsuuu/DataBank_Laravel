@extends('layouts.guru')

@section('title', 'Pembaruan Berkas - Panel Guru')

@section('content')
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg relative shadow-sm">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg relative shadow-sm">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Pembaruan Berkas Administrasi</h2>
        <p class="text-sm text-slate-500 mt-1">Unggah salinan dokumen fisik (PDF/JPG) Anda untuk melengkapi arsip kepegawaian sekolah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="border border-slate-200 bg-white rounded-xl p-6 relative shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Scan KTP Asli</h3>
                    <p class="text-xs text-slate-500 mt-1">Format: JPG/PNG/PDF (Max 5MB).</p>
                </div>
                @if(isset($berkas['ktp']))
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">Sudah Diunggah</span>
                @else
                    <span class="bg-rose-100 text-rose-700 text-xs font-bold px-3 py-1 rounded-full">Belum Diunggah</span>
                @endif
            </div>

            @if(isset($berkas['ktp']))
                <a href="{{ asset('storage/' . $berkas['ktp']) }}" target="_blank" class="text-sm text-blue-600 font-semibold hover:underline mb-4 inline-block">Lihat Dokumen</a>
            @else
                <div class="h-5 mb-4"></div>
            @endif

            <form action="{{ route('guru.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                <input type="hidden" name="jenis_berkas" value="ktp">

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    {{ isset($berkas['ktp']) ? 'Perbarui Dokumen (Opsional)' : 'Pilih File untuk Diunggah' }}
                </label>
                <div class="flex items-center gap-3">
                    <input type="file" name="file_berkas" required accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-lg">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-5 rounded-lg text-sm transition-colors shrink-0">
                        {{ isset($berkas['ktp']) ? 'Update' : 'Unggah' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="border border-slate-200 bg-white rounded-xl p-6 relative shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Ijazah Terakhir</h3>
                    <p class="text-xs text-slate-500 mt-1">Format: JPG/PNG/PDF (Max 5MB).</p>
                </div>
                @if(isset($berkas['ijazah']))
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">Sudah Diunggah</span>
                @else
                    <span class="bg-rose-100 text-rose-700 text-xs font-bold px-3 py-1 rounded-full">Belum Diunggah</span>
                @endif
            </div>

            @if(isset($berkas['ijazah']))
                <a href="{{ asset('storage/' . $berkas['ijazah']) }}" target="_blank" class="text-sm text-blue-600 font-semibold hover:underline mb-4 inline-block">Lihat Dokumen</a>
            @else
                <div class="h-5 mb-4"></div>
            @endif

            <form action="{{ route('guru.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                <input type="hidden" name="jenis_berkas" value="ijazah">

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    {{ isset($berkas['ijazah']) ? 'Perbarui Dokumen (Opsional)' : 'Pilih File untuk Diunggah' }}
                </label>
                <div class="flex items-center gap-3">
                    <input type="file" name="file_berkas" required accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-lg">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-5 rounded-lg text-sm transition-colors shrink-0">
                        {{ isset($berkas['ijazah']) ? 'Update' : 'Unggah' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="border border-slate-200 bg-white rounded-xl p-6 relative shadow-sm md:col-span-2 lg:col-span-1">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">SK Pengangkatan</h3>
                    <p class="text-xs text-slate-500 mt-1">Wajib bagi Guru PNS/PPPK (Max 5MB).</p>
                </div>
                @if(isset($berkas['sk']))
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">Sudah Diunggah</span>
                @else
                    <span class="bg-rose-100 text-rose-700 text-xs font-bold px-3 py-1 rounded-full">Belum Diunggah</span>
                @endif
            </div>

            @if(isset($berkas['sk']))
                <a href="{{ asset('storage/' . $berkas['sk']) }}" target="_blank" class="text-sm text-blue-600 font-semibold hover:underline mb-4 inline-block">Lihat Dokumen</a>
            @else
                <div class="h-5 mb-4"></div>
            @endif

            <form action="{{ route('guru.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                <input type="hidden" name="jenis_berkas" value="sk">

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    {{ isset($berkas['sk']) ? 'Perbarui Dokumen (Opsional)' : 'Pilih File untuk Diunggah' }}
                </label>
                <div class="flex items-center gap-3">
                    <input type="file" name="file_berkas" required accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-lg">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-5 rounded-lg text-sm transition-colors shrink-0">
                        {{ isset($berkas['sk']) ? 'Update' : 'Unggah' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
