<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Service Guru - Bank Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex h-screen bg-slate-50 text-slate-900 overflow-hidden">

    <!-- Sidebar Kiri -->
    <aside class="w-64 flex-shrink-0 border-r border-slate-200 bg-white">
        <div class="flex h-16 items-center border-b border-slate-200 px-6">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500 font-bold text-white">GR</div>
            <span class="ml-3 font-bold text-slate-800">Panel Guru</span>
        </div>
        <nav class="p-4 space-y-1">
            <a href="#" class="flex items-center rounded-lg bg-emerald-50 px-4 py-2.5 text-sm font-medium text-emerald-700">
                Ringkasan Profil
            </a>
            <a href="#" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Riwayat Pendidikan
            </a>
            <a href="#" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Pembaruan Berkas
            </a>
        </nav>
    </aside>

    <!-- Area Konten Utama -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Topbar -->
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">
            <h1 class="text-lg font-semibold text-slate-800">Self-Service Portal</h1>
            <a href="/login" class="text-sm font-medium text-red-600 hover:text-red-700">Keluar</a>
        </header>

        <!-- Konten Halaman -->
        <div class="p-8">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-emerald-500">
                <h2 class="text-xl font-bold text-slate-800">Selamat datang, Bapak/Ibu Guru!</h2>
                <p class="mt-2 text-slate-500">Anda dapat memperbarui data pribadi dan riwayat karier Anda secara mandiri di portal ini.</p>
            </div>
        </div>
    </main>

</body>
</html>
