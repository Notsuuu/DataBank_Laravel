    @extends('layouts.operator')

    @section('header', 'Manajemen Tahun Ajaran')

    @section('content')
    <div class="max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm animate-[fadeIn_0.3s_ease-out]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4">
            <a href="{{ route('akademik.tahun-ajaran') }}" class="px-4 py-2.5 text-sm font-bold bg-blue-50 text-blue-700 rounded-lg border border-blue-200 shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Tahun Ajaran
            </a>
            <a href="{{ route('akademik.kelas') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                Data Kelas
            </a>
            <a href="{{ route('akademik.mapel') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                Mata Pelajaran
            </a>
            <a href="{{ route('akademik.rombel') }}" class="px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg transition-colors border border-transparent hover:border-slate-200">
                Rombongan Belajar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 h-fit overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="font-extrabold text-slate-800 tracking-tight">Tambah Baru</h3>
                </div>
                
                <form action="{{ route('akademik.tahun-ajaran.store') }}" method="POST" class="p-5">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Tahun Ajaran *</label>
                        <input type="text" name="tahun_ajaran" placeholder="Contoh: 2025/2026" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                    </div>
                    
                    <div class="mb-5">
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Semester *</label>
                        <select name="semester" required class="w-full rounded-lg border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-semibold focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-colors">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    
                    <div class="mb-6 flex items-start bg-slate-50 p-3.5 rounded-lg border border-slate-200 shadow-sm">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_active" value="1" class="rounded text-blue-600 border-slate-300 focus:ring-blue-500 h-4 w-4 mt-0.5 cursor-pointer">
                        </div>
                        <div class="ml-3">
                            <label class="text-sm font-bold text-slate-700 cursor-pointer">Jadikan Semester Aktif</label>
                            <p class="text-[10px] font-semibold text-slate-500 mt-0.5">Hanya ada 1 semester aktif dalam satu waktu.</p>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-extrabold tracking-tight">Tahun Ajaran</th>
                                <th class="px-6 py-4 font-extrabold tracking-tight">Semester</th>
                                <th class="px-6 py-4 font-extrabold tracking-tight text-center">Status</th>
                                <th class="px-6 py-4 font-extrabold tracking-tight text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tahunAjarans as $ta)
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-extrabold text-slate-900 text-base">{{ $ta->tahun ?? $ta->tahun_ajaran }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-700 bg-white border border-slate-200 shadow-sm px-3 py-1 rounded-md text-xs">
                                        {{ strtoupper($ta->semester) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ta->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold text-emerald-700 border border-emerald-200 bg-emerald-50 shadow-sm">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold text-slate-500 border border-slate-200 bg-slate-50 shadow-sm">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('akademik.tahun-ajaran.edit', $ta->id) }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Edit</a>
                                        
                                        <form action="{{ route('akademik.tahun-ajaran.destroy', $ta->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus Tahun Ajaran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        <p class="text-sm font-bold text-slate-500">Belum ada data Tahun Ajaran.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection