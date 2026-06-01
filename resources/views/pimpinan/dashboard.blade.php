<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pimpinan - Bank Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex h-screen bg-slate-50 text-slate-900 overflow-hidden">

    <!-- Sidebar Kiri -->
    <aside class="w-64 flex-shrink-0 border-r border-slate-200 bg-white">
        <div class="flex h-16 items-center border-b border-slate-200 px-6">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 font-bold text-white">PM</div>
            <span class="ml-3 font-bold text-slate-800">Panel Pimpinan</span>
        </div>
        <nav class="p-4 space-y-1">
            <a href="#" class="flex items-center rounded-lg bg-amber-50 px-4 py-2.5 text-sm font-medium text-amber-700">
                Statistik Global
            </a>
            <a href="#" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Laporan Kinerja
            </a>
            <a href="#" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Rekapitulasi Data
            </a>
        </nav>
    </aside>

    <!-- Area Konten Utama -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Topbar -->
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">
            <h1 class="text-lg font-semibold text-slate-800">Executive Dashboard</h1>
            <a href="/login" class="text-sm font-medium text-red-600 hover:text-red-700">Keluar</a>
        </header>

        <!-- Konten Halaman -->
        <div class="p-8">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-amber-500">
                <h2 class="text-xl font-bold text-slate-800">Selamat datang, Pimpinan!</h2>
                <p class="mt-2 text-slate-500">Pantau grafik statistik dan monitoring data sekolah secara real-time di sini.</p>
            </div>

            <!-- Contoh Kartu Metrik (Placeholder) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Guru</p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">45</p>
                    </div>
                    <div class="h-10 w-10 bg-amber-50 rounded-full flex items-center justify-center text-amber-600 font-bold">G</div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Siswa</p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">850</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold">S</div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
