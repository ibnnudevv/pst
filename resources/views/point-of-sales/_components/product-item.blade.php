@props(['product'])

<div id="{{ $product->id }}"
    class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 h-fit cursor-pointer"
    data-drawer-target="drawer-example" data-drawer-show="drawer-example" aria-controls="drawer-example"
    data-drawer-backdrop="false" onclick="addToCart({{ json_encode($product) }})">
    <div class="h-56 w-full">
        @if ($product->gambar)
            <img class="mx-auto h-full w-full object-contain" src="{{ $product->gambar }}" alt="" />
        @else
            <img class="mx-auto h-full w-full object-contain object-center"
                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="" />
        @endif
    </div>
    <div class="p-6">
        <div class="mb-4 flex items-center justify-between gap-4">
            @if ($product->diskon != 0)
                <span
                    class="me-2 rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                    Diskon {{ $product->diskon }}%
                </span>
            @else
                <span
                    class="me-2 rounded bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    Tidak ada diskon
                </span>
            @endif
        </div>

        <label
            class="text-base font-semibold leading-tight text-gray-900 hover:underline dark:text-white line-clamp-2 hover:line-clamp-none">
            {{ $product->produk }}
        </label>

        <div class="mt-2 flex items-center gap-2">
            <div class="flex items-center">
                @for ($i = 0; $i < 5; $i++)
                    @if ($i < $product->rating)
                        <svg class="h-4 w-4 text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z" />
                        </svg>
                    @else
                        <svg class="h-4 w-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z" />
                        </svg>
                    @endif
                @endfor
            </div>

            <p class="text-sm font-medium text-gray-900 dark:text-white mb-0 mt-1">
                {{ $product->rating }}.0
            </p>
        </div>

        <ul class="mt-2 lg:flex items-center gap-4">
            <li class="flex items-center gap-2">
                <svg class="h-4 w-4 text-green-500 dark:text-green-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                </svg>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Gratis Ongkir</p>
            </li>

            <li class="flex items-center gap-2">
                <svg class="h-4 w-4 text-orange-500 dark:text-orange-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M8 7V6c0-.6.4-1 1-1h11c.6 0 1 .4 1 1v7c0 .6-.4 1-1 1h-1M3 18v-7c0-.6.4-1 1-1h11c.6 0 1 .4 1 1v7c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">COD</p>
            </li>
        </ul>

        <div class="mt-4 flex items-center justify-between gap-4">
            <div>
                @if ($product->stok > 0)
                    <p class="text-sm font-medium text-gray-600">
                        Stok: {{ $product->stok }}
                    </p>
                @else
                    <p class="text-sm font-medium text-red-500 dark:text-red-400">
                        Stok: Habis
                    </p>
                @endif
                <p class="text-lg font-bold leading-tight text-gray-900 dark:text-white">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>
