<?php
// Create test promo data
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = \Illuminate\Http\Request::capture();
$kernel->handle($request);

use App\Models\Product;
use App\Models\Promo;
use Carbon\Carbon;

// Get first 5 products
$products = Product::where('is_active', true)->limit(5)->get();

if ($products->isEmpty()) {
    echo "❌ Tidak ada produk aktif\n";
    exit;
}

foreach ($products as $i => $product) {
    $discount = 15 + ($i * 5); // 15%, 20%, 25%, 30%, 35%
    $promoPrice = round($product->price * (1 - $discount / 100));
    
    Promo::create([
        'product_id' => $product->id,
        'user_id' => $product->user_id,
        'original_price' => $product->price,
        'promo_price' => $promoPrice,
        'discount_percentage' => $discount,
        'start_date' => Carbon::now()->subHours(1),
        'end_date' => Carbon::now()->addDays(3),
        'quota' => 50,
        'used_quota' => rand(5, 20),
        'is_active' => true,
    ]);
    
    echo "✅ Promo created untuk: {$product->name} - {$discount}% discount\n";
}

echo "\n✨ Selesai! Cek homepage Anda\n";
