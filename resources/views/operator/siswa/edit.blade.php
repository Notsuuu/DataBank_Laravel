@extends('layouts.operator')
@section('header', 'Edit Data Siswa')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <div class="flex items-center gap-4 mb-6 border-b pb-4">
        @if($siswa->foto)
            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-16 h-16 rounded-full object-cover border">
        @else
            <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold border">
                {{ substr($siswa->nama_lengkap, 0, 1) }}
            </div>
        @endif
        <div>
            <h2 class="text-lg font-bold">Edit Profil: {{ $siswa->nama_lengkap }}</h2>
            <p class="text-sm text-slate-500">NIS: {{ $siswa->nis }}</p>
        </div>
    </div>

    <form action="{{ route('operator.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-semibold mb-1">NIS</label><input type="text" name="nis" value="{{ $siswa->nis }}" required class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm font-semibold mb-1">NISN</label><input type="text" name="nisn" value="{{ $siswa->nisn }}" class="w-full rounded-lg border-slate-300"></div>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="col-span-2"><label class="block text-sm font-semibold mb-1">Nama Lengkap</label><input type="text" name="nama_lengkap" value="{{ $siswa->nama_lengkap }}" required class="w-full rounded-lg border-slate-300"></div>
            <div>
                <label class="block text-sm font-semibold mb-1">Gender</label>
                <select name="jenis_kelamin" required class="w-full rounded-lg border-slate-300">
                    <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div><label class="block text-sm font-semibold mb-1">Tempat Lahir</label><input type="text" name="tempat_lahir" value="{{ $siswa->tempat_lahir }}" required class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm font-semibold mb-1">Tgl Lahir</label><input type="date" name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}" required class="w-full rounded-lg border-slate-300"></div>
            <div>
                <label class="block text-sm font-semibold mb-1">Agama</label>
                <select name="agama" required class="w-full rounded-lg border-slate-300">
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'] as $agm)
                        <option value="{{ $agm }}" {{ $siswa->agama == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-semibold mb-1">Nama Wali</label><input type="text" name="nama_wali" value="{{ $siswa->nama_wali }}" class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm font-semibold mb-1">No HP Wali</label><input type="text" name="no_hp_wali" value="{{ $siswa->no_hp_wali }}" class="w-full rounded-lg border-slate-300"></div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Ganti Foto (Kosongkan jika tidak diubah)</label>
            <input type="file" name="foto" accept="image/*" class="w-full border rounded-lg p-2">
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('operator.siswa.index') }}" class="px-6 py-2 bg-slate-100 rounded-lg font-bold">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
