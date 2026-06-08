@extends('layouts.operator')

@section('header', 'Edit Data Guru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50 flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Edit Profil Guru</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Memperbarui data profil atas nama <span class="font-bold text-slate-700">{{ $guru->nama_lengkap }}</span>.</p>
                </div>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                        <strong class="font-bold text-sm">Gagal menyimpan perubahan:</strong>
                        <ul class="mt-2 list-disc list-inside text-xs font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('operator.guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2">
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">1. Identitas Utama</h3>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">NIP <span class="text-slate-400 font-normal">(Kosongkan jika Honorer)</span></label>
                            <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Status Aktif *</label>
                            <select name="status_aktif" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                                <option value="1" {{ old('status_aktif', $guru->status_aktif) == '1' ? 'selected' : '' }}>Aktif Mengajar</option>
                                <option value="0" {{ old('status_aktif', $guru->status_aktif) == '0' ? 'selected' : '' }}>Nonaktif / Pensiun / Pindah</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Gelar Depan</label>
                                <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $guru->gelar_depan) }}" placeholder="Drs." class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Gelar Belakang</label>
                                <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $guru->gelar_belakang) }}" placeholder="S.Pd." class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                            </div>
                        </div>

                        <div class="md:col-span-2 border-b border-slate-100 pb-2 mb-2 mt-4">
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight uppercase">2. Biodata & Kontak</h3>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                                <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Agama *</label>
                            <select name="agama" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                                @php $agama_list = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']; @endphp
                                @foreach($agama_list as $agm)
                                    <option value="{{ $agm }}" {{ old('agama', $guru->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tempat Lahir *</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nomor HP / WA</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">{{ old('alamat', $guru->alamat) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Ganti Foto Profil <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            @if($guru->foto)
                                <div class="mb-3 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Lama" class="h-12 w-12 rounded-lg object-cover border border-slate-200">
                                    <span class="text-xs text-slate-500 font-semibold">Foto saat ini</span>
                                </div>
                            @endif
                            <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg cursor-pointer bg-slate-50 transition-colors">
                            <p class="mt-1.5 text-xs text-slate-400">Biarkan kosong jika tidak ingin mengganti foto. Max 2MB (JPG/PNG).</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('operator.guru.index') }}" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors">
                            Batalkan
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection