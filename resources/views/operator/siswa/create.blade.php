@extends('layouts.operator')

@section('header', 'Tambah Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('operator.siswa.index') }}" class="text-sm font-medium text-slate-500 hover:text-blue-600 flex items-center gap-1 w-fit">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Siswa
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 rounded-lg border border-red-200">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50">
            <h2 class="text-lg font-bold text-slate-800">Form Identitas Siswa</h2>
            <p class="text-sm text-slate-500 mt-1">Pastikan NIS terisi dengan benar karena akan digunakan sebagai identitas utama.</p>
        </div>

        <form action="{{ route('operator.siswa.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Induk Siswa (NIS) <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        <option value="">Pilih...</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 pb-6 border-b border-slate-100">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Agama <span class="text-red-500">*</span></label>
                    <select name="agama" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                    </select>
                </div>
            </div>

            <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Data Tambahan & Wali</h3>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">{{ old('alamat') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b border-slate-100">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Orang Tua / Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP Wali</label>
                    <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali') }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Siswa (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg bg-slate-50 p-2">
                <p class="text-xs text-slate-500 mt-2">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('operator.siswa.index') }}" class="px-6 py-2.5 rounded-lg text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">Simpan Data Siswa</button>
            </div>
        </form>
    </div>
</div>
@endsection
