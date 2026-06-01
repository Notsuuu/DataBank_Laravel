<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Data SMPN 4 Palu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-50 p-6 text-slate-900">
    <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">

        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-xl font-bold text-white shadow-sm">
                S
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang</h2>
            <p class="mt-2 text-sm text-slate-500">Silakan masuk ke akun Anda</p>
        </div>

        <form action="#" method="POST" class="space-y-5">
            <!-- Token Keamanan Laravel -->
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-600 focus:ring-1 focus:ring-blue-600" placeholder="contoh@smpn4palu.sch.id" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition-all focus:border-blue-600 focus:ring-1 focus:ring-blue-600" placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                    <label for="remember" class="ml-2 block text-sm text-slate-700">Ingat saya</label>
                </div>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Lupa sandi?</a>
            </div>

            <button type="submit" class="flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-blue-500">
                Masuk ke Sistem
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            <a href="/" class="hover:text-blue-600 hover:underline">&larr; Kembali ke Beranda</a>
        </div>

    </div>
</body>
</html>
