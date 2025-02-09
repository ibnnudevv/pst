<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Manajemen Produk" :breadcrumbs="[['label' => 'Home', 'url' => '#'], ['label' => 'Point Of Sales', 'url' => '#']]" />
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-xs text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    <span class="sr-only">Gambar</span>
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Produk
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Stok
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Harga
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Diskon
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $data)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b  border-gray-200 text-xs">
                                    <td class="p-4">
                                        <img src="{{ $data->gambar ? $data->gambar : 'https://placehold.co/800@3x.png' }}"
                                            alt="{{ $data->produk }}" class="w-16 h-16 object-cover rounded-lg">
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $data->produk }}
                                        </ts>
                                    <td class="px-6 py-4">
                                        {{ $data->stok }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $data->diskon % 100 == 0 ? $data->diskon / 100 : $data->diskon . '%' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap space-x-2">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Ubah</a>
                                        <a href="#"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
