@extends('layouts.guru')

@section('title', 'Tambah Riwayat Pendidikan - Panel Guru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-4 border-b border-slate-200/80 pb-5">
        <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-200 shadow-sm shadow-emerald-100/50">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Pendidikan</h2>
            <p class="text-sm font-semibold text-slate-500 mt-0.5">Masukkan data perguruan tinggi atau sekolah asal Anda secara akurat.</p>
        </div>
    </div>  

    <div class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 overflow-hidden">
        <form action="{{ route('guru.pendidikan.store') }}" method="POST">
            @csrf

            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Jenjang Pendidikan <span class="text-rose-500">*</span></label>
                        <select name="jenjang" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="D3">Diploma 3 (D3)</option>
                            <option value="D4">Diploma 4 (D4)</option>
                            <option value="S1">Sarjana (S1)</option>
                            <option value="S2">Magister (S2)</option>
                            <option value="S3">Doktor (S3)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tahun Lulus <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun_lulus" required placeholder="Contoh: 2021" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Institusi / Perguruan Tinggi <span class="text-rose-500">*</span></label>
                        <input type="text" name="institusi" required placeholder="Contoh: Universitas Tadulako" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Program Studi / Jurusan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jurusan" required placeholder="Contoh: Teknik Informatika" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-5 bg-slate-50/50 border-t border-slate-100">
                <a href="{{ route('guru.pendidikan') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-100 transition-all shadow-sm shadow-emerald-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan Data
                </button>
            </div>
            
        </form>
    </div>
</div>
@endsection