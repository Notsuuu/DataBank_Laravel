<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Siswa - Bank Data</title>
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
            <a href="/operator/dashboard" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">Beranda</a>
            <a href="/operator/guru" class="flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">Kelola Data Guru</a>
            <a href="/operator/siswa" class="flex items-center rounded-lg bg-blue-50 px-4 py-2.5 text-sm font-medium text-blue-700">Kelola Data Siswa</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">
            <h1 class="text-lg font-semibold text-slate-800">Kelola Data Siswa</h1>
        </header>

        <div class="p-8 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ url('/operator/siswa') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Cari Nama / NISN</label>
                        <input type="text" name="q" placeholder="Ketik Nama atau NISN..." value="{{ $keyword ?? '' }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Filter Kelas</label>
                        <select name="kelas" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:bg-white focus:outline-none">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($semuaKelas as $k)
                                <option value="{{ $k->id }}" {{ ($kelasFilter ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Cari & Filter</button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="p-4">NISN</th>
                            <th class="p-4">Nama Lengkap</th>
                            <th class="p-4">Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-sm">
                        @forelse($para_siswa as $siswa)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 text-slate-700">{{ $siswa->nisn }}</td>
                                <td class="p-4 font-medium text-slate-800">{{ $siswa->nama_lengkap }}</td>
                                <td class="p-4 text-slate-600">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-8 text-center text-slate-400 italic">Data siswa tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
