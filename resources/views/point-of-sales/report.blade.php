<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Point Of Sales') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Manajemen Produk" :breadcrumbs="[
                        ['label' => 'Home', 'url' => '#'],
                        ['label' => 'Point Of Sales', 'url' => route('dashboard')],
                        [
                            'label' => 'Laporan Penjualan',
                            'url' => route('pos.report'),
                        ],
                    ]" />

                    <div class="flex items-center space-x-2">
                        {{-- <x-secondary-button href="{{ route('pos.produk.create') }}" class="ms-3">
                            {{ __('Tambah Produk') }}
                        </x-secondary-button> --}}
                        <x-secondary-button href="{{ route('pos.preview') }}" class="ms-3">
                            {{ __('Preview Penjualan') }}
                        </x-secondary-button>
                        {{-- laporan penjualan --}}
                        <x-secondary-button href="{{ route('pos.report') }}" class="ms-3">
                            {{ __('Laporan Penjualan') }}
                        </x-secondary-button>
                    </div>
                </div>

                {{-- card for totalTransaction and totalIncome --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 my-6">
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="flex items-end justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="p-3 rounded-full bg-blue-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Transaksi</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $totalTransaction }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="flex items-end justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="p-3 rounded-full bg-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ 'Rp ' . number_format($totalIncome, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-xs text-left rtl:text-right text-gray-500 border border-gray-200 rounded-xl">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    Kode Transaksi
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Tanggal
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Total
                                </th>
                                <th scope="col" class="text-sm px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $data)
                                <tr class="border-b  border-gray-200 text-xs items-center">
                                    <td class="px-16 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $data->kode_transaksi }}
                                        </ts>
                                    <td class="px-2 py-2 ">
                                        {{ $data->tanggal }}
                                    </td>
                                    <td class="px-2 py-2 ">
                                        {{ 'Rp ' . number_format($data->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-2 py-2 flex items-center space-x-2">
                                        <x-secondary-button
                                            href="{{ route('pos.detail-report', $data->kode_transaksi) }}">
                                            {{ __('Info') }}
                                        </x-secondary-button>
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
