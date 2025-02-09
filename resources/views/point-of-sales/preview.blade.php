<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview Penjualan') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Preview Penjualan" :breadcrumbs="[['label' => 'Home', 'url' => '#'], ['label' => 'Point Of Sales', 'url' => '#']]" />

                    <x-secondary-button href="{{ route('pos.produk.index') }}" class="ms-3">
                        {{ __('Kembali') }}
                    </x-secondary-button>
                </div>
            </div>

            <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse ($products as $product)
                    @include('point-of-sales._components.product-item', ['product' => $product])
                @empty
                    <div class="col-span-1 lg:col-span-3">
                        <div class="bg-white shadow rounded-lg p-6">
                            <p class="text-center text-gray-500">
                                Tidak ada produk yang ditemukan.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <!-- Drawer component -->
    <div id="drawer-example"
        class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800 w-[20rem] shadow-lg"
        tabindex="-1" aria-labelledby="drawer-label" data-drawer-backdrop="false">
        <h5 id="drawer-label"
            class="flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400 space-x-2">
            Keranjang
            <button type="button" data-drawer-hide="drawer-example" aria-controls="drawer-example"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </h5>

        <div id="drawer-content" class="space-y-4"></div>

        <div class="grid grid-cols-2 gap-4 text-center mt-4">
            <div data-drawer-hide="drawer-example" aria-controls="drawer-example">
                <x-secondary-button class="text-center w-full" href='#'>
                    {{ __('Tutup') }}
                </x-secondary-button>
            </div>
            <div>
                <x-primary-button id="checkoutButton" class="text-center w-full" onclick="checkout()">
                    <span id="checkoutText" class="text-sm">{{ __('Bayar') }}</span>
                    <span id="checkoutLoading" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </x-primary-button>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    @push('scripts')
        <script>
            updateCart();

            function toggleDrawer(show) {
                const drawer = document.getElementById('drawer-example');
                if (show) {
                    drawer.classList.remove('-translate-x-full');
                } else {
                    drawer.classList.add('-translate-x-full');
                }
            }

            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            function removeFromCart(productId) {
                const productIndex = cart.findIndex((item) => item.id === productId);

                if (productIndex !== -1) {
                    cart.splice(productIndex, 1);
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCart();
            }

            function updateQuantity(productId, change) {
                const productIndex = cart.findIndex((item) => item.id === productId);

                if (productIndex !== -1) {
                    const newQuantity = cart[productIndex].jumlah + change;

                    // Check if new quantity is within valid range (1 to stok)
                    if (newQuantity < 1) {
                        toastify().error('Jumlah minimal adalah 1');
                        return;
                    }

                    if (newQuantity > cart[productIndex].stok) {
                        toastify().error('Jumlah melebihi stok yang tersedia');
                        return;
                    }

                    cart[productIndex].jumlah = newQuantity;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCart();
                }
            }

            function addToCart(product) {
                const productIndex = cart.findIndex((item) => item.id === product.id);

                // if stok is empty
                if (product.stok == 0) {
                    toastify().error('Stok produk kosong');
                    return;
                }

                // Only add if product is not already in cart
                if (productIndex === -1) {
                    cart.push({
                        id: product.id,
                        nama_produk: product.produk,
                        harga: product.harga,
                        jumlah: 1,
                        stok: product.stok
                    });

                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCart();
                }
            }

            function updateCart() {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const total = cart.reduce((acc, item) => acc + item.harga * item.jumlah, 0);

                document.getElementById('drawer-content').innerHTML = cart.map((item) => `
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">${item.nama_produk}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Rp ${item.harga * item.jumlah}</p>

                        <div class="flex items-center space-x-2 mt-2">
                            <button
                                onclick="updateQuantity(${item.id}, -1)"
                                class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"
                            >
                                -
                            </button>
                            <span class="text-sm">${item.jumlah}</span>
                            <button
                                onclick="updateQuantity(${item.id}, 1)"
                                class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"
                            >
                                +
                            </button>
                            <span class="text-xs text-gray-500">(Stok: ${item.stok})</span>
                        </div>

                        <button
                            onclick="removeFromCart(${item.id})"
                            class="text-red-500 dark:text-red-400 text-sm mt-2"
                        >
                            Hapus
                        </button>
                    </div>
                `).join('');

                document.querySelector('#drawer-content').insertAdjacentHTML('beforeend', `
                    <div class="flex items-center justify-between pt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Rp ${total}</p>
                    </div>
                `);
            }

            function setCheckoutLoading(isLoading) {
                const button = document.getElementById('checkoutButton');
                const text = document.getElementById('checkoutText');
                const loading = document.getElementById('checkoutLoading');

                button.disabled = isLoading;
                if (isLoading) {
                    text.classList.add('hidden');
                    loading.classList.remove('hidden');
                } else {
                    text.classList.remove('hidden');
                    loading.classList.add('hidden');
                }
            }

            async function checkout() {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];

                if (cart.length === 0) {
                    toastify().error('Keranjang belanja masih kosong');
                    return;
                }

                setCheckoutLoading(true);

                try {
                    const response = await fetch('{{ route('pos.checkout') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            items: cart
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        localStorage.removeItem('cart');
                        updateCart();
                        toggleDrawer(false);
                        toastify().success('Transaksi berhasil');
                        location.reload();
                    } else {
                        toastify().error('Terjadi kesalahan saat memproses transaksi');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    toastify().error('Terjadi kesalahan saat memproses transaksi');
                } finally {
                    setCheckoutLoading(false);
                }
            }
        </script>
    @endpush
</x-app-layout>
