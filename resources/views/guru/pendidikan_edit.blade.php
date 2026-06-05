@extends('layouts.guru')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-2">
    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-xl font-bold text-slate-800">Edit Riwayat Pendidikan</h2>
        <a href="{{ route('guru.pendidikan') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">Kembali</a>
    </div>

    <form action="{{ route('guru.pendidikan.update', $pendidikan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenjang Pendidikan</label>
                <select name="jenjang" required class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                    <option value="SMA/SMK" {{ $pendidikan->jenjang == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                    <option value="D3" {{ $pendidikan->jenjang == 'D3' ? 'selected' : '' }}>D3 (Diploma 3)</option>
                    <option value="S1" {{ $pendidikan->jenjang == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                    <option value="S2" {{ $pendidikan->jenjang == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                    <option value="S3" {{ $pendidikan->jenjang == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Lulus</label>
                <input type="number" name="tahun_lulus" value="{{ $pendidikan->tahun_lulus }}" min="1950" max="{{ date('Y') + 1 }}" required class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Institusi / Universitas</label>
            <input type="text" name="institusi" value="{{ $pendidikan->institusi }}" required class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Fakultas / Program Studi</label>
            <input type="text" name="jurusan" value="{{ $pendidikan->jurusan }}" required class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('guru.pendidikan') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-lg font-bold hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg font-bold shadow-sm hover:bg-emerald-700 transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
