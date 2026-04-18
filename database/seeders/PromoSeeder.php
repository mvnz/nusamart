<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        // Get first 5 active products
        $products = Product::where('is_active', true)->limit(5)->get();

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
                'end_date' => Carbon::now()->addDays(7),
                'quota' => 100,
                'used_quota' => rand(10, 40),
                'is_active' => true,
            ]);
        }
    }
}
