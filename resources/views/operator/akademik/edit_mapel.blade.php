@extends('layouts.operator')

@section('header', 'Edit Mata Pelajaran')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-6">
    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Edit Mapel: {{ $mapel->nama_mapel }}</h3>

    <form action="{{ route('akademik.mapel.update', $mapel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Mapel</label>
            <input type="text" name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm uppercase">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Kelompok Mapel (Opsional)</label>
            <select name="kelompok_mapel" class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                <option value="">-- Pilih Kelompok --</option>
                <option value="Kelompok A (Nasional)" {{ (old('kelompok_mapel', $mapel->kelompok_mapel) == 'Kelompok A (Nasional)') ? 'selected' : '' }}>Kelompok A (Nasional)</option>
                <option value="Kelompok B (Kewilayahan)" {{ (old('kelompok_mapel', $mapel->kelompok_mapel) == 'Kelompok B (Kewilayahan)') ? 'selected' : '' }}>Kelompok B (Kewilayahan)</option>
                <option value="Muatan Lokal" {{ (old('kelompok_mapel', $mapel->kelompok_mapel) == 'Muatan Lokal') ? 'selected' : '' }}>Muatan Lokal</option>
                <option value="Bimbingan Konseling" {{ (old('kelompok_mapel', $mapel->kelompok_mapel) == 'Bimbingan Konseling') ? 'selected' : '' }}>Bimbingan Konseling</option>
            </select>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('akademik.mapel') }}" class="w-1/3 text-center bg-slate-100 text-slate-600 rounded-lg py-2.5 text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="w-2/3 bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
