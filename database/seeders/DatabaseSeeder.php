<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $products = [
            [
                'gambar' => 'https://images.tokopedia.net/img/cache/900/VqbcmM/2024/1/29/cc7e4924-8fb3-4115-b60d-609d75f42d81.jpg',
                'produk' => 'Nokia Wireless Headphones Over-Ear WHP-101 Bluetooth with Mic - Black',
                'stok' => 10,
                'harga' => 500000,
            ],
            [
                'gambar' => '',
                'produk' => 'Logitech Wireless Mouse M185 - Black',
                'stok' => 15,
                'harga' => 150000,
            ],
            [
                'gambar' => '',
                'produk' => 'Samsung EVO Plus MicroSD 128GB Class 10 UHS-I',
                'stok' => 20,
                'harga' => 250000,
            ],
            [
                'gambar' => '',
                'produk' => 'Anker PowerCore 10000mAh Power Bank - Black',
                'stok' => 12,
                'harga' => 350000,
            ],
            [
                'gambar' => '',
                'produk' => 'TP-Link TL-WR840N 300Mbps Wireless Router',
                'stok' => 8,
                'harga' => 200000,
            ],
        ];

        Produk::insert($products);
    }
}
