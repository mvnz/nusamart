<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun penjual sample
        $penjual = User::firstOrCreate(
            ['email' => 'penjual@nusamart.com'],
            [
                'name'     => 'Toko Nusantara',
                'username' => 'toko_nusantara',
                'phone'    => '081300000001',
                'alamat'   => 'Jl. Nusantara No. 1',
                'kota'     => 'Bandung',
                'propinsi' => 'Jawa Barat',
                'role'     => 'penjual',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $products = [
            [
                'name'        => 'Kopi Gayo Premium 250g',
                'description' => 'Kopi arabika asli dari pegunungan Gayo, Aceh. Diproses dengan metode natural untuk menghasilkan cita rasa buah-buahan yang khas dengan body yang kuat.',
                'price'       => 95000,
                'stock'       => 50,
                'category'    => 'Minuman',
            ],
            [
                'name'        => 'Batik Pekalongan Motif Modern',
                'description' => 'Kain batik tulis asli Pekalongan dengan motif modern yang elegan. Cocok untuk berbagai kesempatan formal maupun casual.',
                'price'       => 250000,
                'stock'       => 20,
                'category'    => 'Fashion',
            ],
            [
                'name'        => 'Sambal Matah Bali Asli',
                'description' => 'Sambal matah khas Bali dengan bahan-bahan segar pilihan. Tersedia dalam kemasan 200gr, siap saji.',
                'price'       => 35000,
                'stock'       => 100,
                'category'    => 'Makanan',
            ],
            [
                'name'        => 'Kerajinan Anyaman Bambu',
                'description' => 'Kerajinan tangan anyaman bambu berkualitas tinggi dari pengrajin lokal Jogjakarta. Multi-fungsi sebagai dekorasi maupun wadah penyimpanan.',
                'price'       => 85000,
                'stock'       => 15,
                'category'    => 'Kerajinan',
            ],
            [
                'name'        => 'Minyak Kelapa VCO Murni 500ml',
                'description' => 'Virgin Coconut Oil (VCO) murni cold-pressed dari kelapa segar. Baik untuk kesehatan kulit dan konsumsi.',
                'price'       => 75000,
                'stock'       => 5,
                'category'    => 'Kesehatan',
            ],
            [
                'name'        => 'Rendang Daging Sapi Premium',
                'description' => 'Rendang daging sapi asli Padang dengan bumbu rempah pilihan. Dikemas vakum untuk ketahanan lebih lama.',
                'price'       => 120000,
                'stock'       => 30,
                'category'    => 'Makanan',
            ],
            [
                'name'        => 'Tas Rotan Anyaman Bali',
                'description' => 'Tas rotan handmade dari pengrajin Bali. Desain stylish dan ramah lingkungan, cocok untuk tampilan bohemian.',
                'price'       => 180000,
                'stock'       => 0,
                'category'    => 'Fashion',
            ],
            [
                'name'        => 'Tenun Ikat NTT Original',
                'description' => 'Kain tenun ikat asli Nusa Tenggara Timur. Dibuat dengan teknik tradisional turun-temurun menggunakan pewarna alami.',
                'price'       => 350000,
                'stock'       => 8,
                'category'    => 'Fashion',
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['user_id' => $penjual->id]));
        }
    }
}
