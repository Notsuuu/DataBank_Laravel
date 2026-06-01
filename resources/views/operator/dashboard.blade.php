<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator - Bank Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex h-screen bg-slate-50 text-slate-900 overflow-hidden">

    <aside class="w-64 flex-shrink-0 border-r border-slate-200 bg-white">
        <div class="flex h-16 items-center border-b border-slate-200 px-6">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 font-bold text-white">OP</div>
            <span class="ml-3 font-bold text-slate-800">Panel Operator</span>
        </div>
        <nav class="p-4 space-y-1">
            <a href="#" class="flex items-center rounded-lg bg-blue-50 px-4 py-2.5 text-sm font-medium text-blue-700">
                Beranda
            </a>
            <a href="#" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Kelola Data Guru
            </a>
            <a href="#" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Kelola Data Siswa
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">
            <h1 class="text-lg font-semibold text-slate-800">Ringkasan Sistem</h1>

            <form action="/logout" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm font-medium text-red-600 transition-colors hover:text-red-700">
                    Keluar
                </button>
            </form>

        </header>

        <div class="p-8">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm border-t-4 border-t-blue-600">
                <h2 class="text-xl font-bold text-slate-800">Selamat datang, Operator!</h2>
                <p class="mt-2 text-slate-500">Gunakan menu di sebelah kiri untuk mengelola Bank Data SMPN 4 Palu.</p>
            </div>
        </div>
    </main>

</body>
</html>
