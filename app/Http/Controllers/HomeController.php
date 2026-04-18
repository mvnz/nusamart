<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $statsProductCount = Product::where('is_active', true)->count();
        $statsPenjualCount  = User::where('role', 'penjual')->where('is_active', true)->count();
        $statsOrderCount    = Order::count();

        $featuredProducts = Product::where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

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

        // Daily-seeded 6 flash sale products from DB
        try {
            $seed = crc32(date('Y-m-d'));
            $allProducts = Product::with('category')
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->get();
            $prodArr = $allProducts->all();
            mt_srand($seed);
            for ($i = count($prodArr) - 1; $i > 0; $i--) {
                $j = mt_rand(0, $i);
                [$prodArr[$i], $prodArr[$j]] = [$prodArr[$j], $prodArr[$i]];
            }
            $flashSaleProducts = collect(array_slice($prodArr, 0, 6))->map(function ($p) {
                // Simulate a "before-sale" original price: 20–45% above actual price
                mt_srand($p->id * 7919);
                $pct = mt_rand(20, 45) / 100;
                $originalPrice = (int) round($p->price * (1 + $pct) / 1000) * 1000;
                // Simulated sold count seeded by product id
                $sold = mt_rand(20, 400);
                return [
                    'id'             => $p->id,
                    'name'           => $p->name,
                    'price'          => (int) $p->price,
                    'original_price' => $originalPrice,
                    'image'          => $p->image ? asset('storage/' . $p->image) : null,
                    'category'       => $p->category?->name ?? '-',
                    'sold'           => $sold,
                ];
            })->values()->all();
        } catch (\Exception $e) {
            $flashSaleProducts = [];
        }

        // Tab products: For User / Rekomendasi / Populer (10 each, daily-seeded)
        try {
            $allActive = Product::with(['category', 'seller'])->where('is_active', true)->where('stock', '>', 0)->get();
            $allArr = $allActive->all();
            $dayStr = date('Y-m-d');

            $decorateProduct = function ($p) {
                mt_srand($p->id * 3571);
                $sold = mt_rand(10, 600);
                mt_srand($p->id * 1301);
                $rating = round(mt_rand(40, 50) / 10, 1);
                return [
                    'id'             => $p->id,
                    'name'           => $p->name,
                    'price'          => (int) $p->price,
                    'original_price' => (int) $p->price,
                    'image'          => $p->image ? asset('storage/' . $p->image) : null,
                    'category'       => $p->category?->name ?? '-',
                    'category_id'    => $p->category_id,
                    'seller'         => $p->seller?->name ?? 'NusaMart',
                    'sold'           => $sold,
                    'rating'         => $rating,
                ];
            };

            $shuffle = function (array $arr, int $seed) {
                mt_srand($seed);
                for ($i = count($arr) - 1; $i > 0; $i--) {
                    $j = mt_rand(0, $i);
                    [$arr[$i], $arr[$j]] = [$arr[$j], $arr[$i]];
                }
                return $arr;
            };

            $tabProducts = [
                'for_user'    => collect(array_slice($shuffle($allArr, crc32($dayStr . 'for' . (Auth::id() ?? 0))), 0, 10))->map($decorateProduct)->values()->all(),
                'rekomendasi' => collect(array_slice($shuffle($allArr, crc32($dayStr . 'rek')), 0, 10))->map($decorateProduct)->values()->all(),
                'populer'     => collect(array_slice($shuffle($allArr, crc32($dayStr . 'pop')), 0, 10))->map($decorateProduct)->values()->all(),
            ];
        } catch (\Exception $e) {
            $tabProducts = ['for_user' => [], 'rekomendasi' => [], 'populer' => []];
        }

        // Daily-seeded random categories for promo banners
        try {
            $dbCategories = Category::withCount(['products' => fn($q) => $q->where('is_active', true)])->having('products_count', '>', 0)->get();
            $arr = $dbCategories->all();
            $seed = crc32(date('Y-m-d'));
            mt_srand($seed);
            for ($i = count($arr) - 1; $i > 0; $i--) {
                $j = mt_rand(0, $i);
                [$arr[$i], $arr[$j]] = [$arr[$j], $arr[$i]];
            }
            $promoBanners = collect(array_slice($arr, 0, 3))->map(function ($cat) {
                $image = Product::where('category_id', $cat->id)
                    ->where('is_active', true)
                    ->whereNotNull('image')
                    ->where('image', '!=', '')
                    ->inRandomOrder()
                    ->value('image');
                return ['id' => $cat->id, 'name' => $cat->name, 'image' => $image];
            })->values()->all();
        } catch (\Exception $e) {
            $promoBanners = [];
        }

        // Products with active promos
        try {
            $promoProducts = \App\Models\Promo::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->with(['product' => fn($q) => $q->with('seller', 'category'), 'seller'])
                ->where(fn($q) => $q->where('quota', 0)->orWhereRaw('used_quota < quota'))
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get()
                ->map(function ($promo) {
                    return [
                        'id'              => $promo->product->id,
                        'name'            => $promo->product->name,
                        'price'           => (int) $promo->promo_price,
                        'original_price'  => (int) $promo->original_price,
                        'discount_pct'    => $promo->getDiscountPercentage(),
                        'image'           => $promo->product->image ? asset('storage/' . $promo->product->image) : null,
                        'category'        => $promo->product->category?->name ?? '-',
                        'seller'          => $promo->seller?->name ?? 'NusaMart',
                        'quota_remaining' => $promo->quota > 0 ? $promo->quota - $promo->used_quota : null,
                        'quota_total'     => $promo->quota > 0 ? $promo->quota : null,
                    ];
                })
                ->values()
                ->all();
        } catch (\Exception $e) {
            $promoProducts = [];
        }

        return view('home', compact('categories', 'featuredProducts', 'newProducts', 'sellers', 'promoBanners', 'flashSaleProducts', 'tabProducts', 'promoProducts', 'statsProductCount', 'statsPenjualCount', 'statsOrderCount'));
    }
}
