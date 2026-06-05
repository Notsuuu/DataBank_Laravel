@extends('layouts.operator')

@section('header', 'Tambah Data Guru Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-white">
                <h2 class="text-xl font-bold text-slate-800">Formulir Pendaftaran Guru</h2>
                <p class="text-sm text-slate-500 mt-1">Silakan lengkapi data diri, foto, dan buatkan akun login untuk guru baru.</p>
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

                {{-- TAMBAHKAN BLOK INI: Penangkap error sistem/database --}}
                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <strong class="font-bold">Gagal Menyimpan Database:</strong>
                        <p class="mt-1 text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('operator.guru.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2">
                            <h3 class="text-lg font-semibold text-slate-700">1. Informasi Akun Login</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Email Guru *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Password Sementara *</label>
                            <input type="password" name="password" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                            <h3 class="text-lg font-semibold text-slate-700">2. Profil Pribadi Guru</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">NIP <span class="text-slate-400 font-normal">(Kosongkan jika Honorer)</span></label>
                            <input type="text" name="nip" value="{{ old('nip') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Gelar Depan</label>
                                <input type="text" name="gelar_depan" value="{{ old('gelar_depan') }}" placeholder="Drs." class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Gelar Belakang</label>
                                <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang') }}" placeholder="S.Pd., M.Kom." class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
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

                        <div>
                            <label class="block text-sm font-medium text-slate-700">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Alamat Lengkap *</label>
                            <textarea name="alamat" required rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-medium text-slate-700">Foto Profil <span class="text-slate-400 font-normal">(Opsional, Max 2MB, JPG/PNG)</span></label>
                            <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
                        <a href="{{ route('operator.guru.index') }}" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-2 px-4 rounded-lg mr-3 shadow-sm transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors">
                            Simpan Data Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
