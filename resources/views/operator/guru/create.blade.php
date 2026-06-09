@extends('layouts.operator')

@section('header', 'Tambah Data Guru Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50 flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border-2 border-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Formulir Pendaftaran Guru</h2>
                    <p class="text-sm font-semibold text-slate-500 mt-0.5">Silakan lengkapi data diri, foto, dan buatkan akun login untuk guru baru.</p>
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

                @if(session('error'))
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg shadow-sm">
                        <strong class="font-bold text-sm">Gagal Menyimpan Database:</strong>
                        <p class="mt-1 text-xs font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('operator.guru.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2">
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">1. Informasi Akun Login</h3>
                            <div class="mt-3 bg-blue-50 text-blue-700 px-4 py-3 rounded-lg text-[11px] font-semibold border border-blue-100 flex gap-3 items-start">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p><strong>Sandi Otomatis:</strong> Kata sandi akan dibuat menggunakan <b>NIP</b> (atau <b>'guru123'</b> jika honorer/tanpa NIP). Guru diwajibkan mengganti kata sandi tersebut saat pertama kali masuk ke sistem.</p>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Email Guru *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: guru@smpn4palu.sch.id" class="w-full md:w-1/2 rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Peran Akun</label>
                            <select name="role" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                                <option value="guru" selected>Guru (Default)</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">2. Identitas Utama</h3>
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">NIP <span class="text-slate-400 font-normal">(Kosongkan jika Honorer)</span></label>
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
                                <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang') }}" placeholder="S.Pd." class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
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
                                @php $agama_list = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']; @endphp
                                @foreach($agama_list as $agm)
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
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Alamat Lengkap *</label>
                            <textarea name="alamat" required rows="3" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">4. Berkas Media</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Unggah Foto Profil <span class="text-slate-400 font-semibold">(Opsional)</span></label>
                            <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 transition-colors">
                            <p class="mt-1.5 text-[11px] font-semibold text-slate-400">Max 2MB (JPG/PNG).</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('operator.guru.index') }}" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors">
                            Batalkan
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Simpan Data Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection