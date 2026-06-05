@extends('layouts.operator')

@section('header', 'Edit Data Kelas')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-6">
    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Edit Kelas: {{ $kelas->nama_kelas }}</h3>

    <form action="{{ route('akademik.kelas.update', $kelas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tingkat Kelas</label>
            <select name="tingkat_kelas" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                <option value="VII" {{ (old('tingkat_kelas', $kelas->tingkat_kelas) == 'VII') ? 'selected' : '' }}>Kelas VII (7)</option>
                <option value="VIII" {{ (old('tingkat_kelas', $kelas->tingkat_kelas) == 'VIII') ? 'selected' : '' }}>Kelas VIII (8)</option>
                <option value="IX" {{ (old('tingkat_kelas', $kelas->tingkat_kelas) == 'IX') ? 'selected' : '' }}>Kelas IX (9)</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Ruang/Kelas</label>
            <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Wali Kelas (Opsional)</label>
            <select name="guru_id" class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                <option value="">-- Belum Ditentukan --</option>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ (old('guru_id', $kelas->guru_id) == $guru->id) ? 'selected' : '' }}>
                        {{ $guru->user->name ?? 'Tanpa Nama' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('akademik.kelas') }}" class="w-1/3 text-center bg-slate-100 text-slate-600 rounded-lg py-2.5 text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="w-2/3 bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
