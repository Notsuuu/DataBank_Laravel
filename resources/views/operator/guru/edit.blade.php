@extends('layouts.operator')
@section('header', 'Edit Data Guru')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <h3 class="font-bold text-slate-800 mb-6 border-b pb-2">Edit Data Guru: {{ $guru->user->name ?? 'Tanpa Nama' }}</h3>
    <form action="{{ route('operator.guru.update', $guru->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-semibold mb-1">NIP</label><input type="text" name="nip" value="{{ $guru->nip }}" required class="w-full rounded-lg border-slate-300"></div>
            <div>
                <label class="block text-sm font-semibold mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required class="w-full rounded-lg border-slate-300">
                    <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-semibold mb-1">Tempat Lahir</label><input type="text" name="tempat_lahir" value="{{ $guru->tempat_lahir }}" required class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm font-semibold mb-1">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="{{ $guru->tanggal_lahir }}" required class="w-full rounded-lg border-slate-300"></div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div><label class="block text-sm font-semibold mb-1">Agama</label><input type="text" name="agama" value="{{ $guru->agama }}" required class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm font-semibold mb-1">No HP</label><input type="text" name="no_hp" value="{{ $guru->no_hp }}" required class="w-full rounded-lg border-slate-300"></div>
        </div>
        <div class="flex justify-end gap-3">
            <a href="{{ route('operator.guru.index') }}" class="px-6 py-2 bg-slate-100 rounded-lg font-bold">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
