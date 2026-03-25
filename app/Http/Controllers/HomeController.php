<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = [
            ['icon' => 'fa-cutlery',      'name' => 'Makanan',     'slug' => 'makanan',     'color' => '#e74c3c'],
            ['icon' => 'fa-coffee',       'name' => 'Minuman',     'slug' => 'minuman',     'color' => '#3498db'],
            ['icon' => 'fa-shopping-bag', 'name' => 'Fashion',     'slug' => 'fashion',     'color' => '#9b59b6'],
            ['icon' => 'fa-paint-brush',  'name' => 'Kerajinan',   'slug' => 'kerajinan',   'color' => '#e67e22'],
            ['icon' => 'fa-leaf',         'name' => 'Kesehatan',   'slug' => 'kesehatan',   'color' => '#27ae60'],
            ['icon' => 'fa-pagelines',    'name' => 'Pertanian',   'slug' => 'pertanian',   'color' => '#16a085'],
            ['icon' => 'fa-home',         'name' => 'Rumah Tangga','slug' => 'rumah-tangga','color' => '#f39c12'],
            ['icon' => 'fa-gift',         'name' => 'Souvenir',    'slug' => 'souvenir',    'color' => '#e91e8c'],
        ];

        $featuredProducts = [
            [
                'id' => 1,
                'name' => 'Keripik Tempe Gurih',
                'price' => 18000,
                'original_price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1608500218807-15d28ef8a6b3?w=400&q=80',
                'category' => 'Makanan',
                'seller' => 'Bu Sari UMKM',
                'rating' => 4.8,
                'sold' => 234,
                'badge' => 'Terlaris',
            ],
            [
                'id' => 2,
                'name' => 'Batik Tulis Motif Parang',
                'price' => 185000,
                'original_price' => 250000,
                'image' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=400&q=80',
                'category' => 'Fashion',
                'seller' => 'Batik Jaya Makmur',
                'rating' => 4.9,
                'sold' => 87,
                'badge' => 'Pilihan',
            ],
            [
                'id' => 3,
                'name' => 'Teh Herbal Jahe Merah',
                'price' => 25000,
                'original_price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80',
                'category' => 'Minuman',
                'seller' => 'Herbal Nusantara',
                'rating' => 4.7,
                'sold' => 312,
                'badge' => null,
            ],
            [
                'id' => 4,
                'name' => 'Anyaman Bambu Premium',
                'price' => 75000,
                'original_price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=80',
                'category' => 'Kerajinan',
                'seller' => 'Kerajinan Desa Sari',
                'rating' => 4.6,
                'sold' => 56,
                'badge' => 'Diskon',
            ],
            [
                'id' => 5,
                'name' => 'Sambal Teri Nasi 250gr',
                'price' => 32000,
                'original_price' => 32000,
                'image' => 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=400&q=80',
                'category' => 'Makanan',
                'seller' => 'Dapur Ibu Tini',
                'rating' => 4.9,
                'sold' => 541,
                'badge' => 'Terlaris',
            ],
            [
                'id' => 6,
                'name' => 'Minyak Kelapa Murni',
                'price' => 45000,
                'original_price' => 55000,
                'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400&q=80',
                'category' => 'Kesehatan',
                'seller' => 'Kopra Organik',
                'rating' => 4.5,
                'sold' => 178,
                'badge' => null,
            ],
            [
                'id' => 7,
                'name' => 'Kopi Arabika Lokal 200gr',
                'price' => 68000,
                'original_price' => 80000,
                'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=400&q=80',
                'category' => 'Minuman',
                'seller' => 'Kebun Kopi Nusantara',
                'rating' => 4.8,
                'sold' => 203,
                'badge' => 'Pilihan',
            ],
            [
                'id' => 8,
                'name' => 'Gerabah Hias Motif Etnik',
                'price' => 55000,
                'original_price' => 70000,
                'image' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=400&q=80',
                'category' => 'Kerajinan',
                'seller' => 'Seni Kreatif Desa',
                'rating' => 4.4,
                'sold' => 34,
                'badge' => 'Diskon',
            ],
        ];

        $newProducts = [
            [
                'id' => 9,
                'name' => 'Dodol Coklat Spesial',
                'price' => 28000,
                'original_price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1481391319762-47dff72954d9?w=400&q=80',
                'category' => 'Makanan',
                'seller' => 'Pabrik Dodol Bu Ros',
                'rating' => 4.3,
                'sold' => 12,
                'badge' => 'Baru',
            ],
            [
                'id' => 10,
                'name' => 'Tas Rajut Tangan',
                'price' => 120000,
                'original_price' => 150000,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&q=80',
                'category' => 'Fashion',
                'seller' => 'Rajut Cantik Niken',
                'rating' => 4.7,
                'sold' => 19,
                'badge' => 'Baru',
            ],
            [
                'id' => 11,
                'name' => 'Sirup Rosella Asli',
                'price' => 35000,
                'original_price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1465014925804-7b9ede58d0d7?w=400&q=80',
                'category' => 'Minuman',
                'seller' => 'Herbal Nusantara',
                'rating' => 4.6,
                'sold' => 8,
                'badge' => 'Baru',
            ],
            [
                'id' => 12,
                'name' => 'Lilin Aromaterapi Sereh',
                'price' => 40000,
                'original_price' => 40000,
                'image' => 'https://images.unsplash.com/photo-1603905267635-a2e5b2e3a24c?w=400&q=80',
                'category' => 'Rumah Tangga',
                'seller' => 'Kreasi Desa Wangi',
                'rating' => 4.5,
                'sold' => 5,
                'badge' => 'Baru',
            ],
        ];

        $sellers = [
            ['name' => 'Bu Sari UMKM',         'category' => 'Makanan & Camilan',  'products' => 24, 'rating' => 4.9, 'image' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=D10024&color=fff&size=80'],
            ['name' => 'Batik Jaya Makmur',     'category' => 'Fashion & Tekstil',  'products' => 18, 'rating' => 4.8, 'image' => 'https://ui-avatars.com/api/?name=Batik+Jaya&background=9b59b6&color=fff&size=80'],
            ['name' => 'Herbal Nusantara',       'category' => 'Minuman & Kesehatan','products' => 31, 'rating' => 4.7, 'image' => 'https://ui-avatars.com/api/?name=Herbal&background=27ae60&color=fff&size=80'],
            ['name' => 'Kerajinan Desa Sari',    'category' => 'Kerajinan Tangan',   'products' => 15, 'rating' => 4.6, 'image' => 'https://ui-avatars.com/api/?name=Kerajinan&background=e67e22&color=fff&size=80'],
        ];

        return view('home', compact('categories', 'featuredProducts', 'newProducts', 'sellers'));
    }
}
