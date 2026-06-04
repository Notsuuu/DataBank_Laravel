<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Operator - SMPN 4 Palu</title>
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
            <a href="{{ route('operator.dashboard') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium {{ request()->routeIs('operator.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('operator.guru.index') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium {{ request()->routeIs('operator.guru.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Kelola Data Guru
            </a>
            <a href="{{ route('operator.siswa.index') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium {{ request()->routeIs('operator.siswa.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Kelola Data Siswa
            </a>
            <a href="{{ route('akademik.tahun-ajaran') }}" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium {{ request()->routeIs('akademik.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Kelola Data Akademik
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">
            <h1 class="text-lg font-semibold text-slate-800">
                @yield('header') </h1>

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm font-medium text-red-600 transition-colors hover:text-red-700">Keluar</button>
            </form>
        </header>

        <div class="p-8">
            @yield('content')
        </div>
    </main>

</body>
</html>
