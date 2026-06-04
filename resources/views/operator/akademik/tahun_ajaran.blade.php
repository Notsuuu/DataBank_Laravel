@extends('layouts.operator')

@section('header', 'Manajemen Tahun Ajaran')

@section('content')
<div class="max-w-6xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-blue-50 text-blue-700 px-4 py-3 border border-blue-200 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
            <h3 class="font-bold text-slate-800 mb-4">Tambah Baru</h3>
            <form action="{{ route('akademik.tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" placeholder="Contoh: 2025/2026" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Semester</label>
                    <select name="semester" required class="w-full rounded-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
                <div class="mb-6 flex items-center bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <input type="checkbox" name="is_active" value="1" class="rounded text-blue-600 border-slate-300 focus:ring-blue-500 h-4 w-4">
                    <label class="ml-3 text-sm font-medium text-slate-700">Jadikan Semester Aktif</label>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-blue-700 shadow-sm transition-colors">Simpan Data</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tahun Ajaran</th>
                        <th class="px-6 py-4 font-semibold">Semester</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tahunAjarans as $ta)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $ta->tahun }}</td>
                        <td class="px-6 py-4 font-medium">{{ $ta->semester }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($ta->is_active)
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold border border-blue-200 shadow-sm">AKTIF</span>
                            @else
                                <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-xs font-bold border border-slate-200">TIDAK AKTIF</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <p class="text-slate-500 font-medium">Belum ada data Tahun Ajaran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
