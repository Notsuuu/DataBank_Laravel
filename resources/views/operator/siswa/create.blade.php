@extends('layouts.operator')

@section('header', 'Tambah Data Siswa Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-white">
                <h2 class="text-xl font-bold text-slate-800">Formulir Pendaftaran Siswa</h2>
                <p class="text-sm text-slate-500 mt-1">Lengkapi data diri dan buatkan akun login untuk siswa baru.</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <strong class="font-bold">Oops! Ada yang salah:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('operator.siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2">
                            <h3 class="text-lg font-semibold text-slate-700">1. Informasi Akun Login</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Email Siswa *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Password *</label>
                            <input type="password" name="password" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                            <h3 class="text-lg font-semibold text-slate-700">2. Profil Data Siswa</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">NISN *</label>
                                <input type="text" name="nisn" value="{{ old('nisn') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">NIS (Lokal)</label>
                                <input type="text" name="nis" value="{{ old('nis') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Pilih...</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tempat Lahir *</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Agama *</label>
                            <select name="agama" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Pilih Agama...</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-medium text-slate-700">Pas Foto <span class="text-slate-400 font-normal">(Opsional, Max 2MB, JPG/PNG)</span></label>
                            <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
                        <a href="{{ route('operator.siswa.index') }}" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-2 px-4 rounded-lg mr-3 shadow-sm transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors">
                            Simpan Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
