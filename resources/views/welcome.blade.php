<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Data - SMPN 4 Palu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-slate-50 text-slate-900">

    <header class="border-b border-slate-200 bg-white px-6 py-4 shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-lg font-bold text-white shadow-sm">
                    S
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight">Bank Data Terpusat</h1>
                    <p class="text-xs text-slate-500">SMP Negeri 4 Palu</p>
                </div>
            </div>
            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                <span class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-mono text-slate-600">
                    Laravel v13 + Tailwind v4
                </span>
            </nav>
        </div>
    </header>

    <main class="mx-auto flex w-full max-w-7xl flex-1 flex-col items-center justify-center px-6 py-12 text-center">
        <div class="max-w-4xl space-y-6">
            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                Pusat Informasi Digital
            </div>
            <h2 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Sistem Informasi Bank Data Sekolah
            </h2>
            <p class="mx-auto max-w-2xl text-lg text-slate-600">
                Platform digital terintegrasi untuk pengelolaan data guru, tenaga kependidikan, dan siswa secara mandiri, terstruktur, dan aman.
            </p>

            <div class="grid grid-cols-1 gap-6 pt-10 text-left sm:grid-cols-3">

                <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors hover:border-blue-400 hover:shadow-md">
                    <div>
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-600">OP</div>
                        <h3 class="text-lg font-bold text-slate-900">Portal Operator</h3>
                        <p class="mt-2 text-sm text-slate-500">Akses penuh pengelolaan data guru, siswa, pengarsipan riwayat berkelanjutan, dan laporan.</p>
                    </div>
                    <a href="/operator/dashboard" class="mt-6 block w-full rounded-xl bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition-colors hover:bg-blue-500">
                        Masuk Operator
                    </a>
                </div>

                <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors hover:border-emerald-400 hover:shadow-md">
                    <div>
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 font-bold text-emerald-600">GR</div>
                        <h3 class="text-lg font-bold text-slate-900">Self-Service Guru</h3>
                        <p class="mt-2 text-sm text-slate-500">Akses mandiri khusus guru untuk memperbarui profil pribadi, riwayat karier, dan pendidikan.</p>
                    </div>
                    <a href="/guru/dashboard" class="mt-6 block w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition-colors hover:bg-emerald-500">
                        Masuk Guru
                    </a>
                </div>

                <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors hover:border-amber-400 hover:shadow-md">
                    <div>
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 font-bold text-amber-600">PM</div>
                        <h3 class="text-lg font-bold text-slate-900">Dashboard Pimpinan</h3>
                        <p class="mt-2 text-sm text-slate-500">Akses khusus Kepala Sekolah & Wakasek untuk memantau grafik statistik dan monitoring data.</p>
                    </div>
                    <a href="/pimpinan/dashboard" class="mt-6 block w-full rounded-xl bg-amber-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition-colors hover:bg-amber-500">
                        Masuk Pimpinan
                    </a>
                </div>

            </div>
        </div>
    </main>
</body>
</html>
