<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Currency Rates (DKI Jakarta & Banten Area)') }}
        </h2>
        <p class="text-gray-800 leading-tight mt-2">
            Terakhir diperbarui: {{ date_format($rates[0]->last_update, 'd F Y H:i') }}
        </p>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Currency Rates (DKI Jakarta & Banten Area)" :breadcrumbs="[['label' => 'Home', 'url' => '#'], ['label' => 'Currency Rates', 'url' => '#']]" />

                    <div class="flex items-center space-x-2">
                        <x-secondary-button href="{{ route('currency-rate.scrape') }}" class="ms-3"
                            onclick="scrapeData()">
                            {{ __('Lihat Data Mentah') }}
                        </x-secondary-button>
                    </div>
                </div>

                <p class="text-sm text-gray-600">
                    For some currency there will be different rate that applies to different denomination. For previous
                    version of certain currencies we are not able to exchange. After several inspection process (machine
                    check, UV light Check, and manual check) different rates might apply depending on the condition of
                    the currency
                </p>

                <p class="font-medium text-black mt-4">
                    If an agreement/confirmation of the transaction has occurred, the exchange rate that applies after
                    the agreement/confirmation of the transaction will not affect the transaction that occurs whether
                    the exchange rate increases/decreases.
                </p>

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative mt-4">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">Currency Code
                                </th>
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">Denomination
                                </th>
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">Buy
                                    Rate</th>
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">Sell Rate</th>
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rates as $currencyRate)
                                <tr>
                                    <td class="border-dashed border-t border-gray-200">
                                        {{ $currencyRate->currency_code }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">{{ $currencyRate->denomination }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 text-red-500">
                                        {{ $currencyRate->buy_rate }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 text-green-600">
                                        {{ $currencyRate->sell_rate }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200">{{ $currencyRate->last_update }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
