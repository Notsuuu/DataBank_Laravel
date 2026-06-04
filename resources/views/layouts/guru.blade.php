<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Guru - SMPN 4 Palu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex h-screen bg-slate-50 text-slate-900 overflow-hidden">

    <aside class="w-64 flex-shrink-0 border-r border-slate-200 bg-white">
        <div class="flex h-16 items-center border-b border-slate-200 px-6">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500 font-bold text-white">GR</div>
            <span class="ml-3 font-bold text-slate-800">Panel Guru</span>
        </div>
        <nav class="p-4 space-y-1">
            <a href="{{ route('guru.dashboard') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('guru.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Ringkasan Profil
            </a>
            <a href="{{ route('guru.pendidikan') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('guru.pendidikan') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Riwayat Pendidikan
            </a>
            <a href="{{ route('guru.berkas') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('guru.berkas') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Pembaruan Berkas
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex h-16 flex-shrink-0 items-center justify-between border-b border-slate-200 bg-white px-8">
            <h1 class="text-lg font-semibold text-slate-800">Self-Service Portal</h1>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm font-medium text-red-600 transition-colors hover:text-red-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Keluar
                </button>
            </form>
        </header>

        <div class="p-8 max-w-5xl">
            @yield('content')
        </div>
    </main>
</body>
</html>
