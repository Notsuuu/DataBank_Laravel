@extends('layouts.pimpinan')

@section('header', 'Laporan Kinerja Kepegawaian')

@section('content')

<style>
    @media print {
        /* 1. Sembunyikan Sidebar, Navbar, dan elemen layout lainnya */
        aside, nav, header, footer, .sidebar, .navbar, #sidebar {
            display: none !important;
        }

        /* 2. Paksa area konten utama melebar 100% menutupi kertas */
        body, main, .main-content, #main-content, .container, .ml-64 {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            margin-left: 0 !important; /* Reset margin dari sidebar Tailwind */
        }

        /* 3. Paksa background warna (progress bar & badge) agar ikut tercetak dengan tinta */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* 4. Hilangkan bayangan kotak agar terlihat seperti dokumen resmi */
        .shadow-sm, .shadow {
            box-shadow: none !important;
            border-color: #cbd5e1 !important; /* Warna border disesuaikan agar jelas di kertas */
        }

        /* 5. Mencegah baris tabel terpotong separuh saat pindah ke kertas halaman 2 */
        table { page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }

        /* 6. Hilangkan margin atas yang berlebihan */
        .space-y-6 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 1rem !important;
        }
    }
</style>

<div class="space-y-6 print:space-y-4">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 print:p-0 rounded-2xl shadow-sm border border-slate-200 print:border-none">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Rapor Kepatuhan Administrasi Guru</h2>
            <p class="text-sm text-slate-500 mt-1">Sistem Penilaian Otomatis bersumber dari berkas berkas utama dan pembaruan riwayat pendidikan.</p>
        </div>
        <div class="flex items-center gap-6 shrink-0 bg-slate-50 print:bg-transparent p-4 print:p-0 rounded-xl border border-slate-100 print:border-none">
            <div class="text-right">
                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Rata-rata Kepatuhan Sekolah</p>
                <p class="text-2xl font-black text-orange-600 mt-0.5">{{ number_format($rataRata, 0) }}%</p>
            </div>

            <button onclick="window.print()" class="print:hidden bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-5 rounded-xl text-xs transition-colors shadow-sm">
                🖨️ Cetak Laporan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden print:border-slate-300">
        <div class="overflow-x-auto print:overflow-visible">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 print:bg-slate-100 text-slate-500 text-xs font-black uppercase border-b border-slate-200 tracking-wider">
                        <th class="p-4 print:p-3 whitespace-nowrap w-1/3">Nama Lengkap & Kredensial</th>
                        <th class="p-4 print:p-3 min-w-[280px]">Indikator Progres Administrasi</th>
                        <th class="p-4 print:p-3 text-center whitespace-nowrap">Skor Akhir</th>
                        <th class="p-4 print:p-3 text-center whitespace-nowrap">Status Hasil Evaluasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 print:divide-slate-200 text-sm">
                    @foreach($daftarGuru as $g)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 print:p-3">
                            <p class="font-bold text-slate-800 text-base print:text-sm">{{ $g->nama_lengkap }}</p>
                            <p class="text-xs text-slate-400 font-mono mt-1">NIP: {{ $g->nip }}</p>
                        </td>

                        <td class="p-4 print:p-3">
                            <div class="flex justify-between text-[11px] font-bold mb-1.5">
                                <span class="text-slate-500">Kelengkapan Data</span>
                                <span class="text-slate-700 font-extrabold">{{ $g->skor_kinerja }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 print:bg-slate-200 rounded-full h-2.5 overflow-hidden print:border print:border-slate-300">
                                <div class="h-2.5 rounded-full @if($g->skor_kinerja == 100) bg-emerald-500 @elseif($g->skor_kinerja >= 50) bg-amber-500 @else bg-rose-500 @endif" style="width: {{ $g->skor_kinerja }}%"></div>
                            </div>
                        </td>

                        <td class="p-4 print:p-3 text-center font-black text-xl print:text-base @if($g->skor_kinerja == 100) text-emerald-600 @elseif($g->skor_kinerja >= 50) text-amber-600 @else text-rose-600 @endif">
                            {{ $g->skor_kinerja }}
                        </td>

                        <td class="p-4 print:p-3 text-center">
                            <span class="px-3 py-1.5 print:px-2 print:py-1 print:border-2 rounded-lg text-[11px] print:text-[10px] font-extrabold border {{ $g->badge }} uppercase tracking-wide inline-block">
                                {{ $g->predikat }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
