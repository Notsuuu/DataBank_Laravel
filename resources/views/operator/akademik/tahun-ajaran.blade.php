<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademik - Tahun Ajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Tahun Ajaran</h3>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Tahun Ajaran
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-center border-b">Tahun</th>
                                    <th class="py-3 px-6 text-center border-b">Semester</th>
                                    <th class="py-3 px-6 text-center border-b">Status</th>
                                    <th class="py-3 px-6 text-center border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($tahunAjarans as $ta)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-center font-bold">{{ $ta->tahun }}</td>
                                    <td class="py-3 px-6 text-center uppercase">{{ $ta->semester }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if($ta->is_active)
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Aktif</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <button class="text-blue-500 hover:text-blue-700 mx-1 font-semibold">Edit</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data tahun ajaran.</td>
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
