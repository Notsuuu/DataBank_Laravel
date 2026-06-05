@extends('layouts.operator')

@section('header', 'Edit Tahun Ajaran')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-6">
    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Edit Data: {{ $ta->tahun }}</h3>

    <form action="{{ route('akademik.tahun-ajaran.update', $ta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tahun Ajaran</label>
            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $ta->tahun) }}" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Semester</label>
            <select name="semester" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                <option value="Ganjil" {{ (old('semester', $ta->semester) == 'Ganjil') ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ (old('semester', $ta->semester) == 'Genap') ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <div class="mb-6 flex items-center bg-slate-50 p-3 rounded-lg border border-slate-200">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $ta->is_active) ? 'checked' : '' }} class="rounded text-blue-600 border-slate-300 focus:ring-blue-500 h-4 w-4">
            <label class="ml-3 text-sm font-medium text-slate-700">Jadikan Semester Aktif</label>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('akademik.tahun-ajaran') }}" class="w-1/3 text-center bg-slate-100 text-slate-600 rounded-lg py-2.5 text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="w-2/3 bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
