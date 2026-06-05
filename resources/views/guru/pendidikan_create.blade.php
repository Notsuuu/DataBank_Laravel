@extends('layouts.guru')

@section('title', 'Tambah Riwayat Pendidikan - Panel Guru')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Riwayat Pendidikan</h2>
        <p class="text-sm text-slate-500 mt-1">Masukkan data perguruan tinggi/sekolah asal Anda.</p>
    </div>

    <div class="max-w-3xl rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <form action="{{ route('guru.pendidikan.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenjang Pendidikan *</label>
                    <select name="jenjang" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Pilih Jenjang...</option>
                        <option value="D3">Diploma 3 (D3)</option>
                        <option value="D4">Diploma 4 (D4)</option>
                        <option value="S1">Sarjana (S1)</option>
                        <option value="S2">Magister (S2)</option>
                        <option value="S3">Doktor (S3)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Lulus *</label>
                    <input type="number" name="tahun_lulus" required placeholder="Contoh: 2021" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Institusi / Perguruan Tinggi *</label>
                    <input type="text" name="institusi" required placeholder="Contoh: Universitas Tadulako" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi / Jurusan *</label>
                    <input type="text" name="jurusan" required placeholder="Contoh: Pendidikan Informatika" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('guru.pendidikan') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 shadow-sm">Batal</a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm">Simpan Data</button>
            </div>
        </form>
    </div>
@endsection
