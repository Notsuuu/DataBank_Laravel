@extends('layouts.operator')

@section('title', 'Tambah Pimpinan - Panel Operator')
@section('header', 'Manajemen Jajaran Pimpinan')

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    .ts-control {
        padding: 0.875rem 1rem !important; 
        border-radius: 0.75rem !important; 
        border: 1px solid #cbd5e1 !important;
        background-color: #f8fafc !important;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
    }
    .ts-control.focus {
        background-color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(191, 219, 254, 0.5) !important;
    }
    .ts-dropdown {
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        padding: 0.5rem 0;
    }
    .ts-dropdown .option {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .ts-dropdown .option:hover, .ts-dropdown .active {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
    }
</style>

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-[fadeIn_0.3s_ease-out]">

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
        <div class="border-b border-slate-100 pb-5 mb-6 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800">Tambah Jajaran Pimpinan</h2>
                <p class="text-sm text-slate-500 mt-1 font-medium">Pilih guru aktif yang akan diberikan akses sebagai Kepala Sekolah atau Wakil Kepala Sekolah.</p>
            </div>
        </div>

        <form action="{{ route('operator.pimpinan.store') }}" method="POST">
            @csrf
            
            <div class="mb-8">
                <label for="guru_id" class="block text-sm font-bold text-slate-700 mb-2">Cari Data Guru <span class="text-rose-500">*</span></label>
                
                <select name="guru_id" id="guru_id" required class="w-full cursor-pointer" placeholder="Ketik NIP atau Nama Guru untuk mencari...">
                    <option value="">Ketik NIP atau Nama Guru untuk mencari...</option>
                    @forelse($gurus as $guru)
                        <option value="{{ $guru->id }}">
                            {{ $guru->nip ? $guru->nip . ' - ' : '' }} 
                            {{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada guru aktif yang tersedia.</option>
                    @endforelse
                </select>
                
                @error('guru_id')
                    <div class="flex items-center gap-1 mt-2 text-rose-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-xs font-bold">{{ $message }}</p>
                    </div>
                @else
                    <p class="text-xs font-semibold text-slate-400 mt-2">Ketik nama atau NIP, lalu klik pada hasil yang muncul.</p>
                @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6 pt-6 border-t border-slate-100">
                <a href="{{ route('operator.pimpinan.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 text-center transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-500/30 text-center transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Simpan ke Jajaran Pimpinan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect("#guru_id", {
            create: false,       
            maxOptions: 50,      
            sortField: {
                field: "text",
                direction: "asc" 
            }
        });
    });
</script>
@endsection