<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Pimpinan - Bank Data')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="relative flex h-screen bg-slate-50/50 text-slate-800 antialiased overflow-hidden">

    <div class="absolute top-0 right-0 -z-10 h-[400px] w-[400px] rounded-full bg-orange-500/5 blur-[100px]"></div>
    <div class="absolute bottom-12 left-64 -z-10 h-[300px] w-[300px] rounded-full bg-amber-500/5 blur-[90px]"></div>

    <aside class="w-68 flex flex-shrink-0 flex-col justify-between border-r border-slate-200/80 bg-white px-4 py-5 shadow-sm">
        <div>
            <div class="flex items-center gap-3 border-b border-slate-100 pb-5 mx-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-orange-500 to-amber-600 font-extrabold text-white shadow-md shadow-orange-500/20">
                    PM
                </div>
                <div>
                    <span class="block font-extrabold tracking-tight text-slate-900 text-md">Panel Pimpinan</span>
                    <span class="block text-[11px] font-bold text-orange-600 uppercase tracking-wider">Bank Data Sekolah</span>
                </div>
            </div>

            <div class="mt-4 mx-2 rounded-xl bg-slate-50 border border-slate-100 p-3">
                <div class="flex items-center gap-2">
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="currentColor">
                        <path d="M224 128v704h576V128H224zm-32-64h640a32 32 0 0 1 32 32v768a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V96a32 32 0 0 1 32-32z"></path>
                        <path d="M64 832h896v64H64zm256-640h128v96H320z"></path>
                        <path d="M384 832h256v-64a128 128 0 1 0-256 0v64zm128-256a192 192 0 0 1 192 192v128H320V768a192 192 0 0 1 192-192zM320 384h128v96H320zm256-192h128v96H576zm0 192h128v96H576z"></path>
                    </svg>
                    <span class="text-xs font-bold text-slate-700">SMP Negeri 4 Palu</span>
                </div>
            </div>

            <nav class="mt-6 space-y-1.5">
                <a href="{{ route('pimpinan.dashboard') }}"
                    class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pimpinan.dashboard') ? 'bg-orange-600 text-white shadow-md shadow-orange-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 transition-colors {{ request()->routeIs('pimpinan.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6" />
                    </svg>
                    Beranda
                </a>

                <a href="{{ route('pimpinan.profil') }}"
                    class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pimpinan.profil') ? 'bg-orange-600 text-white shadow-md shadow-orange-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 transition-colors {{ request()->routeIs('pimpinan.profil') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Profil Saya
                </a>
                <a href="{{ route('pimpinan.pendidikan') }}"
                    class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pimpinan.pendidikan*') ? 'bg-orange-600 text-white shadow-md shadow-orange-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 transition-colors {{ request()->routeIs('pimpinan.pendidikan*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" /></svg>
                    Pendidikan
                </a>
                <a href="{{ route('pimpinan.berkas') }}"
                    class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pimpinan.berkas') ? 'bg-orange-600 text-white shadow-md shadow-orange-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 transition-colors {{ request()->routeIs('pimpinan.berkas') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Berkas Pimpinan
                </a>
                <a href="{{ route('pimpinan.laporan_kinerja') }}"
                    class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pimpinan.laporan_kinerja') ? 'bg-orange-600 text-white shadow-md shadow-orange-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 flex-shrink-0 transition-colors {{ request()->routeIs('pimpinan.laporan_kinerja') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Laporan Kinerja
                </a>
            </nav>
        </div>

        <div class="border-t border-slate-100 pt-4 mx-2">
            <div class="flex items-center justify-between rounded-xl bg-slate-50 p-3 border border-slate-100">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-orange-100 font-bold text-orange-700 text-sm ring-2 ring-white">
                        {{ Str::upper(substr(auth()->user()->name ?? 'PM', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <span class="block truncate text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'Nama Pimpinan' }}</span>
                        <span class="block text-[10px] font-semibold text-slate-400 truncate">Kepala Sekolah</span>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline flex-shrink-0">
                    @csrf
                    <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition-all duration-200 hover:bg-red-50 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="flex h-16 flex-shrink-0 items-center justify-between border-b border-slate-200/80 bg-white px-8 shadow-sm">
            <div class="flex items-center gap-3">
                <h1 class="text-md font-bold text-slate-900 sm:text-lg tracking-tight">@yield('header', 'Beranda Pimpinan')</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 rounded-xl bg-slate-50 border border-slate-200/60 px-3 py-1.5">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-600">{{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            <div class="mx-auto max-w-7xl animate-[fadeIn_0.3s_ease-out]">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        let idleTime = 0;
        const maxIdleTime = 30;
        const idleInterval = setInterval(function() {
            idleTime++;
            if (idleTime >= maxIdleTime) {
                clearInterval(idleInterval);
                alert('Sesi berakhir otomatis demi keamanan.');
                document.getElementById('logout-form').submit();
            }
        }, 60000);
        function resetTimer() { idleTime = 0; }
        ['mousemove', 'keydown', 'mousedown', 'scroll'].forEach(event => { window.addEventListener(event, resetTimer, true); });
    </script>
</body>
</html>
