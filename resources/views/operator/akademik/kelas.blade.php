<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Kelas</h3>
                        <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Kelas
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-center border-b w-24">Tingkat</th>
                                    <th class="py-3 px-6 text-left border-b">Nama Kelas</th>
                                    <th class="py-3 px-6 text-left border-b">Wali Kelas</th>
                                    <th class="py-3 px-6 text-center border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($kelas as $k)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-center font-bold">{{ $k->tingkat }}</td>
                                    <td class="py-3 px-6 text-left">{{ $k->nama_kelas }}</td>
                                    <td class="py-3 px-6 text-left text-emerald-700 font-semibold">
                                        {{ $k->waliKelas ? $k->waliKelas->nama_lengkap : 'Belum Ditentukan' }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <button class="text-blue-500 hover:text-blue-700 font-semibold">Edit</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data kelas.</td>
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
