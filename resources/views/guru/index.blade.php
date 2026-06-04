<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Guru SMPN 4 Palu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Guru</h3>
                        <a href="{{ route('guru.create') }} "class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Guru
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left border-b">NIP</th>
                                    <th class="py-3 px-6 text-left border-b">Nama Lengkap</th>
                                    <th class="py-3 px-6 text-left border-b">L/P</th>
                                    <th class="py-3 px-6 text-center border-b">No HP</th>
                                    <th class="py-3 px-6 text-center border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($gurus as $guru)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $guru->nip ?? '-' }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}</td>
                                    <td class="py-3 px-6 text-left">{{ $guru->jenis_kelamin }}</td>
                                    <td class="py-3 px-6 text-center">{{ $guru->no_hp ?? '-' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <button class="text-blue-500 hover:text-blue-700 mx-1 font-semibold">Edit</button>
                                        <button class="text-red-500 hover:text-red-700 mx-1 font-semibold">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">Belum ada data guru.</td>
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
