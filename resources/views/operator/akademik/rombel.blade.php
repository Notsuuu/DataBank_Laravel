<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademik - Rombongan Belajar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Distribusi Rombel Siswa</h3>
                        <button class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded shadow">
                            + Masukkan Siswa ke Kelas
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left border-b">Nama Siswa</th>
                                    <th class="py-3 px-6 text-center border-b">Kelas</th>
                                    <th class="py-3 px-6 text-center border-b">Tahun Ajaran</th>
                                    <th class="py-3 px-6 text-center border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($rombels as $rombel)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left font-bold text-gray-800">{{ $rombel->siswa->nama_lengkap ?? 'Siswa Terhapus' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $rombel->kelas->nama_kelas ?? 'Kelas Terhapus' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">{{ $rombel->tahunAjaran->tahun ?? '-' }} ({{ $rombel->tahunAjaran->semester ?? '-' }})</td>
                                    <td class="py-3 px-6 text-center">
                                        <button class="text-red-500 hover:text-red-700 font-semibold">Pindahkan</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada siswa yang terdaftar di rombel.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
