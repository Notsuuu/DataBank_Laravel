@extends('layouts.pimpinan')

@section('title', 'Edit Riwayat Pendidikan - Panel Pimpinan')
@section('header', 'Edit Pendidikan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-4 border-b border-slate-200/80 pb-5">
        <div class="h-12 w-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center border border-orange-200 shadow-sm shadow-orange-100/50">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Edit Pendidikan</h2>
            <p class="text-sm font-semibold text-slate-500 mt-0.5">Perbarui data perguruan tinggi atau sekolah asal Anda.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 overflow-hidden">
        <form action="{{ route('pimpinan.pendidikan.update', $pendidikan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Jenjang Pendidikan <span class="text-rose-500">*</span></label>
                        <select name="jenjang" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-colors">
                            <option value="SMA/SMK" {{ $pendidikan->jenjang == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ $pendidikan->jenjang == 'D3' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                            <option value="D4" {{ $pendidikan->jenjang == 'D4' ? 'selected' : '' }}>Diploma 4 (D4)</option>
                            <option value="S1" {{ $pendidikan->jenjang == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                            <option value="S2" {{ $pendidikan->jenjang == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                            <option value="S3" {{ $pendidikan->jenjang == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tahun Lulus <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun_lulus" value="{{ $pendidikan->tahun_lulus }}" min="1950" max="{{ date('Y') + 1 }}" required placeholder="Contoh: 2021" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Institusi / Perguruan Tinggi <span class="text-rose-500">*</span></label>
                        <input type="text" name="institusi" value="{{ $pendidikan->institusi }}" required placeholder="Contoh: Universitas Tadulako" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Program Studi / Jurusan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jurusan" value="{{ $pendidikan->jurusan }}" required placeholder="Contoh: Teknik Informatika" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-colors">
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-5 bg-slate-50/50 border-t border-slate-100">
                <a href="{{ route('pimpinan.pendidikan') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-orange-600 rounded-xl hover:bg-orange-700 focus:ring-4 focus:ring-orange-100 transition-all shadow-sm shadow-orange-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
