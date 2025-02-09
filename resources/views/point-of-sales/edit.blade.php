<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div>
        <section class="antialiased">
            <div class="mx-auto px-4 2xl:px-0">
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <x-breadcrumb pageTitle="Edit Produk" :breadcrumbs="[['label' => 'Home', 'url' => '#'], ['label' => 'Point Of Sales', 'url' => '#']]" />

                    <x-secondary-button href="{{ route('pos.produk.index') }}" class="ms-3">
                        {{ __('Kembali') }}
                    </x-secondary-button>
                </div>

                <form action="{{ route('pos.produk.update', $produk->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="gambar"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                            <input type="text" name="gambar" id="gambar"
                                value="{{ old('gambar', $produk->gambar) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-400"
                                placeholder="Masukkan URL gambar">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="produk"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Produk</label>
                            <input type="text" name="produk" id="produk"
                                value="{{ old('produk', $produk->produk) }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-400"
                                placeholder="Masukkan nama produk">
                        </div>
                        <div class="w-full">
                            <label for="stok"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}"
                                required min="0"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-400"
                                placeholder="Jumlah stok">
                        </div>
                        <div class="w-full">
                            <label for="harga"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                            <input type="number" name="harga" id="harga"
                                value="{{ old('harga', $produk->harga) }}" required min="0"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-400"
                                placeholder="Masukkan harga">
                        </div>
                        <div>
                            <label for="diskon"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diskon (%)</label>
                            <input type="number" name="diskon" id="diskon"
                                value="{{ old('diskon', $produk->diskon) }}" min="0" max="100"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-400"
                                placeholder="Masukkan diskon">
                        </div>
                        <div>
                            <label for="rating"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rating
                                (0-5)</label>
                            <input type="number" name="rating" id="rating"
                                oninput="this.value = Math.min(this.value, 5);this.value = Math.max(this.value, 0);"
                                value="{{ old('rating', $produk->rating) }}" min="0" max="5"
                                step="0.1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-400"
                                placeholder="Masukkan rating (0-5)">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 placeholder:text-gray-400"
                                placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-semibold text-center text-white bg-gray-700 rounded-lg focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-900 hover:bg-gray-800 uppercase">
                        Update Produk
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-app-layout>
