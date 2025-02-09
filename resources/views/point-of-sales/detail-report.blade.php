<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Point Of Sales') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0 mt-8">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Detail Transaksi" :breadcrumbs="[
                        ['label' => 'Home', 'url' => '#'],
                        ['label' => 'Point Of Sales', 'url' => route('dashboard')],
                        [
                            'label' => 'Laporan Penjualan',
                            'url' => route('pos.report'),
                        ],
                        [
                            'label' => 'Detail Transaksi',
                            'url' => route('pos.detail-report', $transaction->kode_transaksi),
                        ],
                    ]" />

                    <div class="flex items-center space-x-2">
                        <x-secondary-button href="{{ route('pos.preview') }}" class="ms-3">
                            {{ __('Preview Penjualan') }}
                        </x-secondary-button>
                        <x-secondary-button href="{{ route('pos.report') }}" class="ms-3">
                            {{ __('Laporan Penjualan') }}
                        </x-secondary-button>
                    </div>
                </div>

                <div class="mx-auto p-6 max-w-xl border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-900">Kode Transaksi</h2>
                        <p class="text-sm font-normal text-gray-900">{{ $transaction->kode_transaksi }}</p>
                    </div>
                    {{-- tanggal transaksi --}}
                    <div class="flex items-center justify-between mt-2">
                        <h2 class="text-sm font-semibold text-gray-900">Tanggal Transaksi</h2>
                        <p class="text-sm font-normal text-gray-900">{{ $transaction->tanggal }}</p>
                    </div>
                    <br />
                    <hr class="my-4 border border-gray-200">
                    <br />

                    {{-- list produk --}}

                    @foreach ($transaction->produk as $item)
                        {{--
                            nama produk x jumlah
                            harga
                        --}}

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 my-6">
                            <div>
                                <p class="text-sm text-gray-500">{{ $item->produk }}</p>
                                <p class="text-sm text-gray-500">x {{ $item->quantity }}</p>
                            </div>
                            <div style="place-self: end;">
                                <p class="text-sm font-semibold text-gray-900">
                                    Rp {{ $item->harga }}</p>
                            </div>
                        </div>

                        {{-- border  --}}
                        @if (!$loop->last)
                            <hr class="my-4 border border-gray-200">
                        @endif
                    @endforeach

                    <hr class="my-4 border border-gray-200">

                    {{-- total transaksi --}}
                    <div class="flex items-center justify-between mt-2">
                        <h2 class="text-sm font-semibold text-gray-900">Total Transaksi</h2>
                        <p class="text-lg font-semibold text-gray-900">Rp
                            {{ number_format($transaction->total, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
