@extends('layouts.pimpinan')

@section('title', 'Pembaruan Berkas - Panel Pimpinan')
@section('header', 'Pembaruan Dokumen')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 px-4 py-3 border border-emerald-200 rounded-xl flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 text-rose-700 px-4 py-3 border border-rose-200 rounded-xl flex items-start gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="list-disc list-inside text-sm font-semibold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center gap-4 border-b border-slate-200/80 pb-5">
        <div class="h-12 w-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center border border-orange-200 shadow-sm shadow-orange-100/50">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Pembaruan Dokumen</h2>
            <p class="text-sm font-semibold text-slate-500 mt-0.5">Unggah salinan dokumen fisik asli Anda untuk validasi kepegawaian pimpinan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <div class="lg:col-span-4 bg-slate-50/50 rounded-2xl border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-200">
                <div class="h-8 w-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="font-bold text-slate-800">Unggah Berkas Baru</h3>
            </div>

            <form action="{{ route('pimpinan.berkas.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Jenis Dokumen <span class="text-rose-500">*</span></label>
                    <select name="jenis_berkas" required class="w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-colors shadow-sm">
                        <option value="">-- Pilih Dokumen --</option>
                        <option value="ktp">Scan KTP Asli</option>
                        <option value="ijazah">Ijazah Terakhir</option>
                        <option value="sk">SK Pengangkatan (PNS/PPPK)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Pilih File <span class="text-rose-500">*</span></label>
                    <input type="file" name="file_berkas" required accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer outline-none bg-white border border-slate-300 rounded-xl shadow-sm transition-colors">
                    <p class="text-[10px] font-semibold text-slate-400 mt-1.5">Format: JPG, PNG, PDF. Maksimal 5MB.</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 rounded-xl text-sm transition-all shadow-sm shadow-orange-500/30 flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Simpan Berkas
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <tr>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Jenis Dokumen</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight">Keterangan</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight text-center">Status</th>
                            <th class="px-6 py-4 font-extrabold tracking-tight text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">Scan KTP Asli</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-500">Wajib Diunggah</td>
                            <td class="px-6 py-4 text-center">
                                @if($pimpinan->file_ktp)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Tersimpan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold text-rose-600 bg-rose-50 border border-rose-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span> Kosong
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($pimpinan->file_ktp)
                                    <a href="{{ asset('storage/' . $pimpinan->file_ktp) }}" target="_blank" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Lihat Dokumen</a>
                                @else
                                    <span class="text-sm font-semibold text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">Ijazah Terakhir</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-500">Wajib Diunggah</td>
                            <td class="px-6 py-4 text-center">
                                @if($pimpinan->file_ijazah)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Tersimpan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold text-rose-600 bg-rose-50 border border-rose-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span> Kosong
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($pimpinan->file_ijazah)
                                    <a href="{{ asset('storage/' . $pimpinan->file_ijazah) }}" target="_blank" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Lihat Dokumen</a>
                                @else
                                    <span class="text-sm font-semibold text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">SK Pengangkatan</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-500">Khusus PNS/PPPK</td>
                            <td class="px-6 py-4 text-center">
                                @if($pimpinan->file_sk)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Tersimpan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold text-slate-600 bg-slate-100 border border-slate-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Opsional
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($pimpinan->file_sk)
                                    <a href="{{ asset('storage/' . $pimpinan->file_sk) }}" target="_blank" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Lihat Dokumen</a>
                                @else
                                    <span class="text-sm font-semibold text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
