<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class InaExportProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dapatkan akun seller aditya.budi
        $seller = User::where('username', 'aditya.budi')->first();
        
        if (!$seller) {
            $this->command->error('Seller aditya.budi tidak ditemukan!');
            return;
        }

        $products = [
            // Kopi dan Minuman Kesehatan
            [
                'name'        => 'TOKIBI COFFEE - 12 INDONESIAN SELECTIONS',
                'description' => 'Pilihan kopi terbaik dari Arabika dan Robusta dari 12 daerah penghasil kopi terbaik di seluruh nusantara, dari Sumatera hingga Papua. Memberikan pengalaman rasa yang unik dan autentik dari setiap region.',
                'price'       => 150000,
                'stock'       => 50,
                'category'    => 'Beverage & Coffee',
            ],
            [
                'name'        => 'INDONESIAN ARABICA COFFEE BEANS - SEMI WASHED',
                'description' => 'Biji kopi Arabika hijau asli Indonesia dengan proses semi-washed, bersumber dari petani pilihan di Jawa Barat. Memberikan cita rasa yang kompleks dengan aciditas seimbang.',
                'price'       => 120000,
                'stock'       => 100,
                'category'    => 'Beverage & Coffee',
            ],
            [
                'name'        => 'INDONESIAN ROBUSTA COFFEE BEANS - NATURAL PROCESS',
                'description' => 'Biji kopi Robusta hijau asli Indonesia dengan proses fermentasi alami, bersumber dari petani pilihan. Body kuat dengan rasa earthy yang karakteristik.',
                'price'       => 95000,
                'stock'       => 150,
                'category'    => 'Beverage & Coffee',
            ],
            [
                'name'        => 'ROBUSTA GREEN COFFEE BEANS GRADE 1',
                'description' => 'Kopi Robusta hijau grade 1 berkualitas ekspor dari Indonesia. Spesifikasi: Black Max 2%, Damage Max 2%, Foreign Max 2%, Moisture Max 12%.',
                'price'       => 110000,
                'stock'       => 200,
                'category'    => 'Beverage & Coffee',
            ],
            [
                'name'        => 'ROBUSTA GREEN COFFEE BEANS GRADE 3',
                'description' => 'Kopi Robusta hijau grade 3 dari Indonesia. Spesifikasi: Black Max 15%, Damage Max 15%, Foreign Max 15%, Moisture Max 13%. Cocok untuk keperluan komersial.',
                'price'       => 75000,
                'stock'       => 300,
                'category'    => 'Beverage & Coffee',
            ],
            
            // Rempah-Rempah dan Bumbu
            [
                'name'        => 'BLACK PEPPER - WHOLE SEEDS EXPORT QUALITY',
                'description' => 'Biji merica hitam utuh berkualitas ekspor dari Indonesia. Kulit berkerut dengan rasa pedas maksimal, sempurna untuk digiling segar. Tidak mengubah warna hidangan.',
                'price'       => 85000,
                'stock'       => 80,
                'category'    => 'Spices & Herbs',
            ],
            [
                'name'        => 'WHITE PEPPER - CLEAN PEELED SEEDS',
                'description' => 'Merica putih berkualitas ekspor, biji utuh yang telah dikupas bersih. Rasa pedas ringan, sempurna untuk sup jernih dan hidangan yang membutuhkan rasa pedas tanpa warna gelap.',
                'price'       => 105000,
                'stock'       => 60,
                'category'    => 'Spices & Herbs',
            ],
            [
                'name'        => 'ONION POWDER - PURE NATURAL',
                'description' => 'Bubuk bawang bombay murni 100% natural. Alternatif praktis untuk bawang segar, memberikan rasa gurih dan manis (umami) sempurna untuk sup, saus, dan pasta.',
                'price'       => 45000,
                'stock'       => 120,
                'category'    => 'Spices & Herbs',
            ],
            [
                'name'        => 'DRIED PUYANG CHILIES - ULES WOOD FRUIT',
                'description' => 'Buah kayu ules (cabai puyang kering) yang penting dalam pengobatan tradisional. Digunakan untuk mengatasi masuk angin dan kram perut. Rasa pedas dengan aroma khas.',
                'price'       => 65000,
                'stock'       => 40,
                'category'    => 'Spices & Herbs',
            ],
            
            // Fashion dan Aksesori Kulit
            [
                'name'        => 'VERTICAL LEATHER WALLET - GENUINE COWHIDE',
                'description' => 'Dompet kulit vertikal asli dari kulit sapi berkualitas tinggi. Ukuran 9x2x12 cm, warna hitam, berat 175 gram. Dilengkapi 2 slot uang dan 10 slot kartu dengan resleting.',
                'price'       => 250000,
                'stock'       => 25,
                'category'    => 'Leather & Fashion',
            ],
            
            // Produk Teknologi dan Elektronik
            [
                'name'        => 'WIRELESS SMART LED BULB - RGB COLORFUL',
                'description' => 'Lampu LED pintar nirkabel dengan 16 juta pilihan warna RGB. Dapat dikontrol via aplikasi smartphone, hemat energi hingga 80%, tahan lama hingga 50.000 jam.',
                'price'       => 175000,
                'stock'       => 35,
                'category'    => 'Electronics & Technology',
            ],
            [
                'name'        => 'USB FAST CHARGER 65W MULTI PORT',
                'description' => 'Pengisi daya cepat USB dengan teknologi Fast Charging untuk berbagai device. 4 port USB dapat mengisi 4 perangkat sekaligus. Garansi 2 tahun, sertifikat internasional.',
                'price'       => 125000,
                'stock'       => 50,
                'category'    => 'Electronics & Technology',
            ],
            
            // Produk Kecantikan dan Perawatan Pribadi
            [
                'name'        => 'NATURAL FACE MASK - ACTIVATED CHARCOAL',
                'description' => 'Masker wajah arang aktif 100% natural. Membersihkan pori-pori, mengurangi jerawat, dan meremajakan kulit. Untuk semua jenis kulit, aman tanpa bahan kimia berbahaya.',
                'price'       => 65000,
                'stock'       => 70,
                'category'    => 'Beauty & Personal Care',
            ],
            [
                'name'        => 'ORGANIC COCONUT OIL VIRGIN - COLD PRESSED 500ML',
                'description' => 'Minyak kelapa virgin murni hasil cold-pressed tanpa panas. Kaya akan manfaat untuk kesehatan kulit, rambut, dan konsumsi. Tidak mengandung pengawet atau pewarna.',
                'price'       => 75000,
                'stock'       => 60,
                'category'    => 'Beauty & Personal Care',
            ],
            [
                'name'        => 'HERBAL SKINCARE SET - TRADITIONAL RECIPE',
                'description' => 'Rangkaian skincare herbal tradisional Indonesia dengan resep turun-temurun. Cocok untuk perawatan kulit tropis, mengandung ekstrak alami dari tumbuhan pilihan.',
                'price'       => 185000,
                'stock'       => 40,
                'category'    => 'Beauty & Personal Care',
            ],
            
            // Makanan Tradisional dan Kerajinan
            [
                'name'        => 'SAMBAL MATAH BALI ASLI - 200G',
                'description' => 'Sambal matah khas Bali dibuat dengan bahan-bahan segar pilihan. Kombinasi sempurna antara cabai, bawang merah, dan rempah lainnya. Siap saji dalam kemasan higienis.',
                'price'       => 45000,
                'stock'       => 100,
                'category'    => 'Traditional Food',
            ],
            [
                'name'        => 'RENDANG DAGING SAPI PREMIUM - PADANG',
                'description' => 'Rendang daging sapi asli Padang dengan bumbu rempah pilihan. Dikemas vakum untuk daya tahan lebih panjang. Siap untuk dinikmati, cukup panaskan.',
                'price'       => 155000,
                'stock'       => 50,
                'category'    => 'Traditional Food',
            ],
            [
                'name'        => 'KERAJINAN ANYAMAN BAMBU NUSANTARA',
                'description' => 'Kerajinan tangan anyaman bambu berkualitas tinggi dari pengrajin lokal Yogyakarta. Multi-fungsi sebagai dekorasi interior maupun wadah penyimpanan fashion dan aksesori.',
                'price'       => 125000,
                'stock'       => 30,
                'category'    => 'Handicraft & Souvenirs',
            ],
            [
                'name'        => 'TAS ROTAN ANYAMAN BALI - HANDMADE',
                'description' => 'Tas rotan handmade dari pengrajin Bali dengan desain stylish dan ramah lingkungan. Cocok untuk tampilan bohemian contemporary, dapat digunakan untuk berbagai kesempatan.',
                'price'       => 225000,
                'stock'       => 20,
                'category'    => 'Handicraft & Souvenirs',
            ],
            [
                'name'        => 'TENUN IKAT NTT ORIGINAL - WOVEN WITH NATURAL DYE',
                'description' => 'Kain tenun ikat asli Nusa Tenggara Timur dibuat dengan teknik tradisional turun-temurun. Menggunakan pewarna alami dari tumbuhan lokal, setiap piece adalah karya seni yang unik.',
                'price'       => 450000,
                'stock'       => 15,
                'category'    => 'Handicraft & Souvenirs',
            ],
            [
                'name'        => 'BATIK PEKALONGAN - MOTIF MODERN KONTEMPORER',
                'description' => 'Kain batik tulis asli Pekalongan dengan motif modern yang elegan dan aktualisasi kontemporer. Cocok untuk berbagai kesempatan formal maupun casual, hasil karya pengrajin berpengalaman.',
                'price'       => 320000,
                'stock'       => 18,
                'category'    => 'Handicraft & Souvenirs',
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['user_id' => $seller->id]));
        }

        $this->command->info('Berhasil menambahkan ' . count($products) . ' produk untuk seller aditya.budi!');
    }
}
