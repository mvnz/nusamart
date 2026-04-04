<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SampleProductSeeder extends Seeder
{
    public function run(): void
    {
        // Seller
        $penjual = User::firstOrCreate(
            ['email' => 'penjual@nusamart.com'],
            [
                'name'               => 'Toko Nusantara',
                'username'           => 'toko_nusantara',
                'phone'              => '081300000001',
                'alamat'             => 'Jl. Nusantara No. 1',
                'kota'               => 'Bandung',
                'propinsi'           => 'Jawa Barat',
                'role'               => 'penjual',
                'password'           => bcrypt('password'),
                'email_verified_at'  => now(),
            ]
        );

        // Categories
        $categoryNames = ['Makanan', 'Minuman', 'Fashion', 'Kerajinan', 'Kesehatan', 'Elektronik'];
        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[$name] = Category::firstOrCreate(['name' => $name]);
        }

        // Picsum photo IDs — each ID gives a consistent product-like image
        // 30 unique IDs matched to product categories
        $products = [
            // ── Makanan (5) ──────────────────────────────────────────
            [
                'name'        => 'Rendang Daging Sapi Premium',
                'description' => 'Rendang daging sapi asli Padang dengan bumbu rempah pilihan. Dikemas vakum untuk ketahanan hingga 3 bulan.',
                'price'       => 120000,
                'stock'       => 30,
                'category'    => 'Makanan',
                'photo_id'    => 292,
            ],
            [
                'name'        => 'Sambal Matah Bali Asli',
                'description' => 'Sambal matah khas Bali dengan bahan-bahan segar pilihan. Tersedia dalam kemasan 200gr, siap saji.',
                'price'       => 35000,
                'stock'       => 100,
                'category'    => 'Makanan',
                'photo_id'    => 488,
            ],
            [
                'name'        => 'Keripik Tempe Malang 150g',
                'description' => 'Keripik tempe renyah khas Malang dibuat dari kedelai pilihan. Tersedia rasa original, pedas, dan balado.',
                'price'       => 28000,
                'stock'       => 80,
                'category'    => 'Makanan',
                'photo_id'    => 1080,
            ],
            [
                'name'        => 'Dodol Garut Original 250g',
                'description' => 'Dodol asli Garut dengan rasa manis legit yang khas. Terbuat dari bahan alami tanpa pengawet.',
                'price'       => 42000,
                'stock'       => 60,
                'category'    => 'Makanan',
                'photo_id'    => 431,
            ],
            [
                'name'        => 'Pempek Palembang Isi 10',
                'description' => 'Pempek asli Palembang sudah termasuk cuko. Tersedia varian kapal selam, lenjer, dan adaan.',
                'price'       => 75000,
                'stock'       => 25,
                'category'    => 'Makanan',
                'photo_id'    => 425,
            ],
            // ── Minuman (5) ──────────────────────────────────────────
            [
                'name'        => 'Kopi Gayo Premium 250g',
                'description' => 'Kopi arabika asli dari pegunungan Gayo, Aceh. Diproses dengan metode natural, cita rasa fruity dengan body kuat.',
                'price'       => 95000,
                'stock'       => 50,
                'category'    => 'Minuman',
                'photo_id'    => 312,
            ],
            [
                'name'        => 'Teh Hijau Puncak 100g',
                'description' => 'Teh hijau organik dari kebun teh Puncak Bogor. Kaya antioksidan, aroma segar alami.',
                'price'       => 55000,
                'stock'       => 70,
                'category'    => 'Minuman',
                'photo_id'    => 225,
            ],
            [
                'name'        => 'Wedang Jahe Rempah Sachet (20 pcs)',
                'description' => 'Minuman wedang jahe rempah instan khas Jogja. Menghangatkan tubuh dan menjaga imun, tanpa bahan kimia.',
                'price'       => 30000,
                'stock'       => 120,
                'category'    => 'Minuman',
                'photo_id'    => 326,
            ],
            [
                'name'        => 'Kopi Toraja Arabika 200g',
                'description' => 'Kopi arabika single origin dari Toraja, Sulawesi Selatan. Profil rasa herbal dan earthy yang unik.',
                'price'       => 88000,
                'stock'       => 40,
                'category'    => 'Minuman',
                'photo_id'    => 766,
            ],
            [
                'name'        => 'Sirup Markisa Asli Medan 630ml',
                'description' => 'Sirup markisa asli buatan Medan dari buah markisa segar pilihan. Rasa asam manis yang menyegarkan.',
                'price'       => 45000,
                'stock'       => 55,
                'category'    => 'Minuman',
                'photo_id'    => 1048,
            ],
            // ── Fashion (5) ──────────────────────────────────────────
            [
                'name'        => 'Batik Pekalongan Motif Modern',
                'description' => 'Kain batik tulis asli Pekalongan dengan motif modern yang elegan. Cocok untuk formal maupun casual.',
                'price'       => 250000,
                'stock'       => 20,
                'category'    => 'Fashion',
                'photo_id'    => 696,
            ],
            [
                'name'        => 'Tas Rotan Anyaman Bali',
                'description' => 'Tas rotan handmade dari pengrajin Bali. Desain stylish dan ramah lingkungan, cocok untuk tampilan bohemian.',
                'price'       => 180000,
                'stock'       => 15,
                'category'    => 'Fashion',
                'photo_id'    => 581,
            ],
            [
                'name'        => 'Tenun Ikat NTT Original',
                'description' => 'Kain tenun ikat asli Nusa Tenggara Timur. Dibuat dengan teknik tradisional menggunakan pewarna alami.',
                'price'       => 350000,
                'stock'       => 8,
                'category'    => 'Fashion',
                'photo_id'    => 668,
            ],
            [
                'name'        => 'Kebaya Encim Katun Premium',
                'description' => 'Kebaya encim bahan katun premium motif bordir halus. Cocok untuk acara pernikahan, wisuda, dan formal lainnya.',
                'price'       => 420000,
                'stock'       => 12,
                'category'    => 'Fashion',
                'photo_id'    => 701,
            ],
            [
                'name'        => 'Sandal Kulit Sapi Jogja Handmade',
                'description' => 'Sandal kulit sapi asli buatan tangan pengrajin Jogja. Nyaman, tahan lama, dan stylish.',
                'price'       => 135000,
                'stock'       => 30,
                'category'    => 'Fashion',
                'photo_id'    => 607,
            ],
            // ── Kerajinan (5) ────────────────────────────────────────
            [
                'name'        => 'Kerajinan Anyaman Bambu Jogja',
                'description' => 'Kerajinan tangan anyaman bambu berkualitas tinggi dari pengrajin lokal Jogjakarta. Multi-fungsi sebagai dekorasi maupun wadah.',
                'price'       => 85000,
                'stock'       => 15,
                'category'    => 'Kerajinan',
                'photo_id'    => 359,
            ],
            [
                'name'        => 'Wayang Kulit Tokoh Punakawan',
                'description' => 'Wayang kulit asli buatan dalang Surakarta, tokoh Punakawan (Semar, Gareng, Petruk, Bagong). Cocok sebagai hiasan dinding.',
                'price'       => 550000,
                'stock'       => 5,
                'category'    => 'Kerajinan',
                'photo_id'    => 249,
            ],
            [
                'name'        => 'Topeng Kayu Bali Ukiran Tangan',
                'description' => 'Topeng kayu Bali diukir tangan oleh seniman lokal, kayu albasia. Tersedia motif Barong, Rangda, dan Legong.',
                'price'       => 195000,
                'stock'       => 10,
                'category'    => 'Kerajinan',
                'photo_id'    => 395,
            ],
            [
                'name'        => 'Gerabah Kasongan Yogyakarta',
                'description' => 'Gerabah keramik asli Kasongan Yogyakarta berbentuk guci dekoratif. Proses pembakaran tradisional.',
                'price'       => 145000,
                'stock'       => 18,
                'category'    => 'Kerajinan',
                'photo_id'    => 372,
            ],
            [
                'name'        => 'Ukiran Kayu Jepara Miniatur',
                'description' => 'Ukiran kayu jati miniatur rumah adat Jawa dari pengrajin Jepara. Detail halus, cocok sebagai souvenir.',
                'price'       => 220000,
                'stock'       => 7,
                'category'    => 'Kerajinan',
                'photo_id'    => 285,
            ],
            // ── Kesehatan (5) ────────────────────────────────────────
            [
                'name'        => 'Minyak Kelapa VCO Murni 500ml',
                'description' => 'Virgin Coconut Oil cold-pressed dari kelapa segar. Baik untuk kulit, rambut, dan konsumsi harian.',
                'price'       => 75000,
                'stock'       => 45,
                'category'    => 'Kesehatan',
                'photo_id'    => 1024,
            ],
            [
                'name'        => 'Jamu Kunyit Asam Sachet (10 pcs)',
                'description' => 'Jamu kunyit asam tradisional dalam kemasan sachet praktis. Membantu menjaga kesehatan dan kecantikan dari dalam.',
                'price'       => 25000,
                'stock'       => 100,
                'category'    => 'Kesehatan',
                'photo_id'    => 429,
            ],
            [
                'name'        => 'Minyak Zaitun Terapeutik 100ml',
                'description' => 'Minyak zaitun extra virgin untuk perawatan kulit dan rambut. Cocok untuk kulit kering dan sensitif.',
                'price'       => 65000,
                'stock'       => 35,
                'category'    => 'Kesehatan',
                'photo_id'    => 824,
            ],
            [
                'name'        => 'Masker Spirulina Organik 50g',
                'description' => 'Masker wajah bubuk spirulina organik. Membersihkan pori-pori, mencerahkan, dan melembabkan kulit secara alami.',
                'price'       => 48000,
                'stock'       => 60,
                'category'    => 'Kesehatan',
                'photo_id'    => 1062,
            ],
            [
                'name'        => 'Kayu Manis Bubuk Organik 100g',
                'description' => 'Kayu manis Ceylon organik digiling halus. Membantu menstabilkan gula darah dan kaya antioksidan.',
                'price'       => 38000,
                'stock'       => 80,
                'category'    => 'Kesehatan',
                'photo_id'    => 165,
            ],
            // ── Elektronik (5) ───────────────────────────────────────
            [
                'name'        => 'Powerbank 10000mAh Fast Charging',
                'description' => 'Powerbank kapasitas 10.000mAh dengan teknologi fast charging 22.5W. Kompak, ringan, dilengkapi LED indicator.',
                'price'       => 185000,
                'stock'       => 40,
                'category'    => 'Elektronik',
                'photo_id'    => 119,
            ],
            [
                'name'        => 'Earphone TWS Bluetooth 5.3',
                'description' => 'True Wireless Stereo earphone Bluetooth 5.3 dengan noise cancellation. Baterai tahan 6 jam, case charging 24 jam.',
                'price'       => 245000,
                'stock'       => 25,
                'category'    => 'Elektronik',
                'photo_id'    => 356,
            ],
            [
                'name'        => 'Kabel Data USB-C 1m Braided',
                'description' => 'Kabel USB-C 1 meter bahan braided nylon premium. Mendukung fast charging 60W dan transfer data 480Mbps.',
                'price'       => 45000,
                'stock'       => 150,
                'category'    => 'Elektronik',
                'photo_id'    => 442,
            ],
            [
                'name'        => 'Stand HP Meja Adjustable Aluminium',
                'description' => 'Stand holder HP dan tablet dari aluminium dengan sudut yang bisa disetel. Cocok untuk video call, nonton, dan gaming.',
                'price'       => 78000,
                'stock'       => 55,
                'category'    => 'Elektronik',
                'photo_id'    => 180,
            ],
            [
                'name'        => 'Lampu LED Ring Light 10 Inch',
                'description' => 'Ring light LED 10 inch dengan 3 mode warna (warm/natural/cool) dan 10 level kecerahan. Cocok untuk konten kreator.',
                'price'       => 135000,
                'stock'       => 30,
                'category'    => 'Elektronik',
                'photo_id'    => 343,
            ],
        ];

        foreach ($products as $data) {
            $cat = $categories[$data['category']];

            $product = Product::updateOrCreate(
                ['name' => $data['name'], 'user_id' => $penjual->id],
                [
                    'description' => $data['description'],
                    'price'       => $data['price'],
                    'stock'       => $data['stock'],
                    'category'    => $data['category'],
                    'category_id' => $cat->id,
                    'is_active'   => true,
                ]
            );

            // Download image if not already set
            if (!$product->image) {
                $imagePath = $this->downloadImage($data['photo_id'], $product->id);
                if ($imagePath) {
                    $product->update(['image' => $imagePath]);
                }
            }
        }
    }

    private function downloadImage(int $photoId, int $productId): ?string
    {
        try {
            $url      = "https://picsum.photos/id/{$photoId}/600/600";
            $response = Http::timeout(15)->get($url);

            if ($response->successful()) {
                $filename = "products/product_{$productId}.jpg";
                Storage::disk('public')->put($filename, $response->body());
                return $filename;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download image for product {$productId}: " . $e->getMessage());
        }

        return null;
    }
}