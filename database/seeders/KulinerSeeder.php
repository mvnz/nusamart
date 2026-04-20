<?php

namespace Database\Seeders;

use App\Models\Kuliner;
use Illuminate\Database\Seeder;

class KulinerSeeder extends Seeder
{
    public function run(): void
    {
        $kuliners = [
            [
                'nama'      => 'Warung Nasi Ibu Sari',
                'deskripsi' => 'Warung nasi rumahan legendaris di Desa Manud Jaya yang sudah berdiri sejak 1998. Menyajikan masakan Sunda autentik seperti nasi liwet, ayam goreng kampung, dan lalapan segar setiap harinya. Cocok untuk sarapan dan makan siang bersama keluarga.',
                'gambar'    => 'kuliner/placeholder.jpg',
                'alamat'    => 'Jl. Raya Manud Jaya No. 12, RT 02/RW 01, Desa Manud Jaya',
                'jam_buka'  => '06:00',
                'jam_tutup' => '15:00',
                'kontak_wa' => '6281234567890',
                'kategori'  => 'Makanan Berat',
                'link_maps' => null,
                'status'    => 'buka',
            ],
            [
                'nama'      => 'Es Dawet Pak Hendra',
                'deskripsi' => 'Minuman tradisional es dawet segar dengan cendol buatan sendiri, santan kelapa asli, dan gula aren khas Manud Jaya. Cocok dinikmati di siang hari yang terik. Sudah melayani warga desa selama lebih dari 15 tahun.',
                'gambar'    => 'kuliner/placeholder.jpg',
                'alamat'    => 'Depan Balai Desa Manud Jaya, RT 01/RW 02',
                'jam_buka'  => '09:00',
                'jam_tutup' => '17:00',
                'kontak_wa' => '6282345678901',
                'kategori'  => 'Minuman',
                'link_maps' => null,
                'status'    => 'buka',
            ],
            [
                'nama'      => 'Warung Seafood Bang Udin',
                'deskripsi' => 'Warung seafood dengan bahan segar langsung dari nelayan lokal. Menu andalan: ikan bakar bumbu kecap, cumi goreng tepung, dan kepiting saus tiram. Tersedia tempat duduk lesehan yang nyaman dengan pemandangan sawah.',
                'gambar'    => 'kuliner/placeholder.jpg',
                'alamat'    => 'Jl. Pesisir Manud No. 5, RT 03/RW 03, Desa Manud Jaya',
                'jam_buka'  => '11:00',
                'jam_tutup' => '22:00',
                'kontak_wa' => '6283456789012',
                'kategori'  => 'Seafood',
                'link_maps' => null,
                'status'    => 'buka',
            ],
            [
                'nama'      => 'Kue Tradisional Bu Lastri',
                'deskripsi' => 'Toko jajanan pasar tradisional dengan aneka kue basah khas Sunda seperti klepon, onde-onde, cucur, dan getuk lindri. Semua dibuat dari bahan alami tanpa pewarna buatan. Tersedia juga pesanan untuk acara hajatan dan arisan.',
                'gambar'    => 'kuliner/placeholder.jpg',
                'alamat'    => 'Pasar Desa Manud Jaya, Kios No. 7',
                'jam_buka'  => '05:00',
                'jam_tutup' => '12:00',
                'kontak_wa' => '6284567890123',
                'kategori'  => 'Jajanan',
                'link_maps' => null,
                'status'    => 'buka',
            ],
            [
                'nama'      => 'Bakso & Mie Ayam Pak Sugeng',
                'deskripsi' => 'Bakso dengan kuah kaldu sapi yang kaya rasa dan mie ayam dengan topping jamur serta ayam suwir berbumbu. Porsi besar dan harga terjangkau menjadi daya tarik utama warung ini di kalangan warga Desa Manud Jaya.',
                'gambar'    => 'kuliner/placeholder.jpg',
                'alamat'    => 'Jl. Gotong Royong No. 3, RT 04/RW 02, Desa Manud Jaya',
                'jam_buka'  => '08:00',
                'jam_tutup' => '20:00',
                'kontak_wa' => '6285678901234',
                'kategori'  => 'Makanan Berat',
                'link_maps' => null,
                'status'    => 'buka',
            ],
            [
                'nama'      => 'Warung Kopi Mbah Joyo',
                'deskripsi' => 'Warung kopi tradisional yang menjadi tempat nongkrong favorit warga. Menyajikan kopi hitam robusta lokal, teh poci, dan aneka camilan seperti pisang goreng, singkong rebus, dan tempe mendoan. Suasana santai dan akrab.',
                'gambar'    => 'kuliner/placeholder.jpg',
                'alamat'    => 'Pojok Alun-alun Desa Manud Jaya, RT 01/RW 01',
                'jam_buka'  => '05:30',
                'jam_tutup' => '23:00',
                'kontak_wa' => '6286789012345',
                'kategori'  => 'Minuman',
                'link_maps' => null,
                'status'    => 'buka',
            ],
        ];

        foreach ($kuliners as $kuliner) {
            Kuliner::create($kuliner);
        }
    }
}
