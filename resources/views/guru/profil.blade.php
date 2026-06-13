@extends('layouts.guru')

@section('title', 'Profil Saya - Panel Guru')
@section('header', 'Profil Saya')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 px-4 py-3 border border-emerald-200 rounded-xl flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="bg-emerald-50 text-emerald-700 px-4 py-3 border border-emerald-200 rounded-xl flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold text-sm">Password Anda berhasil diperbarui!</span>
        </div>
    @endif

    <div class="flex items-center gap-4 border-b border-slate-200/80 pb-5">
        <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-200 shadow-sm shadow-emerald-100/50">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        </div>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Profil Saya</h2>
            <p class="text-sm font-semibold text-slate-500 mt-0.5">Kelola identitas diri, data kepegawaian, dan kredensial keamanan Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <div class="lg:col-span-4 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 p-6 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-emerald-50 to-white"></div>

                <div class="relative group mb-4 mt-4">
                    @if($user->guru->foto)
                        <img src="{{ asset('storage/' . $user->guru->foto) }}" class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-md bg-slate-100 relative z-10">
                    @else
                        <div class="h-32 w-32 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-4xl font-black border-4 border-white shadow-md relative z-10">
                            {{ Str::upper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <h3 class="font-extrabold text-slate-800 text-lg relative z-10">{{ $user->guru->gelar_depan }} {{ $user->name }} {{ $user->guru->gelar_belakang }}</h3>
                <p class="text-sm font-semibold text-emerald-600 mt-1 relative z-10">NIP. {{ $user->guru->nip ?? 'Non-PNS' }}</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 p-6">
                @csrf
                @method('PUT')

                <h3 class="font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Ubah Password
                </h3>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Password Saat Ini</label>
                        <input type="password" name="current_password" required class="w-full rounded-xl bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-slate-500 focus:bg-white transition-colors {{ $errors->updatePassword->has('current_password') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-300' }}">
                        @error('current_password', 'updatePassword')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Password Baru</label>
                        <input type="password" name="password" required class="w-full rounded-xl bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-slate-500 focus:bg-white transition-colors {{ $errors->updatePassword->has('password') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-300' }}">
                        @error('password', 'updatePassword')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-slate-500 focus:bg-white transition-colors">
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-2">
                        Perbarui Password
                    </button>
                </div>
            </form>

        </div>

        <div class="lg:col-span-8">
            <form action="{{ route('guru.profil.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-200/80 p-6 md:p-8">
                @csrf
                @method('PUT')

                <h3 class="font-bold text-slate-800 mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    Data Pribadi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->guru->nama_lengkap) }}" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Gelar Depan</label>
                        <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $user->guru->gelar_depan) }}" placeholder="Contoh: Drs." class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $user->guru->gelar_belakang) }}" placeholder="Contoh: S.Pd., M.Kom." class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin', $user->guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $user->guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Agama <span class="text-rose-500">*</span></label>
                        <select name="agama" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                            @php $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']; @endphp
                            <option value="">-- Pilih --</option>
                            @foreach($agamaList as $agm)
                                <option value="{{ $agm }}" {{ old('agama', $user->guru->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tempat Lahir <span class="text-rose-500">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->guru->tempat_lahir) }}" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->guru->tanggal_lahir) }}" required class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Nomor HP/WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->guru->no_hp) }}" placeholder="Contoh: 08123456789" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Alamat Domisili</label>
                        <textarea name="alamat" rows="3" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">{{ old('alamat', $user->guru->alamat) }}</textarea>
                    </div>
                </div>

                <h3 class="font-bold text-slate-800 mb-6 mt-8 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Data Kepegawaian
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Status Pegawai</label>
                        <select name="status_pegawai" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                            <option value="">-- Pilih Status --</option>
                            @php $statusList = ['PNS', 'P3K', 'P3K PW']; @endphp
                            @foreach($statusList as $status)
                                <option value="{{ $status }}" {{ old('status_pegawai', $user->guru->status_pegawai) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Pangkat / Golongan</label>
                        <input type="text" name="pangkat_gol" value="{{ old('pangkat_gol', $user->guru->pangkat_gol) }}" placeholder="Contoh: Penata Muda / III/a" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Jabatan Akademik</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $user->guru->jabatan) }}" placeholder="Contoh: Guru Mata Pelajaran / Wali Kelas" class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 transition-colors">
                    </div>
                        
                    <div class="md:col-span-2 mt-4 border-t border-slate-100 pt-4">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Ganti Foto Profil</label>
                        <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl bg-slate-50 transition-colors">
                        <p class="mt-1.5 text-[11px] font-bold text-slate-400">Pilih foto untuk mengganti profil. Format JPG/PNG (Max. 2MB).</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end pt-5 border-t border-slate-100">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition-all shadow-sm shadow-emerald-500/30 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Profil & Dokumen
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection 