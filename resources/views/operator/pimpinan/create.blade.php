@extends('layouts.operator')

@section('header', 'Tambah Data Pimpinan Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-slate-50 flex items-center gap-4">
            <div class="h-14 w-14 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold border-2 border-white shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Pendaftaran Akun Pimpinan</h2>
                <p class="text-sm font-semibold text-slate-500 mt-0.5">Lengkapi data untuk mendaftarkan Kepala Sekolah atau Wakil Kepala Sekolah.</p>
            </div>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg shadow-sm">
                    <strong class="font-bold text-sm">Oops! Gagal menyimpan data:</strong>
                    <ul class="mt-2 list-disc list-inside text-xs font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('operator.pimpinan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2">
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">1. Informasi Akun Login</h3>
                        <div class="mt-3 bg-blue-50 text-blue-700 px-4 py-3 rounded-lg text-[11px] font-semibold border border-blue-100 flex gap-3 items-start">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p><strong>Sandi Otomatis:</strong> Kata sandi akan dibuat menggunakan <b>NIP</b>. Sistem ini secara otomatis akan mengatur Role pengguna menjadi <b>Pimpinan</b>.</p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Email Dinas / Resmi *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: kepsek@smpn4palu.sch.id" class="w-full md:w-1/2 rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                    </div>

                    <input type="hidden" name="role" value="pimpinan">

                    <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">2. Identitas Utama</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Gelar Depan</label>
                            <input type="text" name="gelar_depan" value="{{ old('gelar_depan') }}" placeholder="Drs." class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Gelar Belakang</label>
                            <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang') }}" placeholder="M.Pd." class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>
                    </div>

                    <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">3. Biodata & Kontak</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Agama *</label>
                        <select name="agama" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'] as $agm)
                                <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Lengkap *</label>
                        <textarea name="alamat" required rows="3" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                        <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">4. Berkas Media</h3>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Unggah Foto Profil <span class="text-slate-400 font-semibold">(Opsional)</span></label>
                        <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-800 file:text-white hover:file:bg-slate-900 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 transition-colors">
                        <p class="mt-1.5 text-[11px] font-semibold text-slate-400">Max 2MB (JPG/PNG).</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('operator.pimpinan.index') }}" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors">
                        Batalkan
                    </a>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Simpan Data Pimpinan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
