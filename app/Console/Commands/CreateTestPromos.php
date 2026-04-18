<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateTestPromos extends Command
{
    protected $signature = 'promo:create-test';
    protected $description = 'Create test promo data';

    public function handle()
    {
        $products = Product::where('is_active', true)->limit(5)->get();

        if ($products->isEmpty()) {
            $this->error('No active products found');
            return;
        }

        foreach ($products as $i => $product) {
            $discount = 15 + ($i * 5);
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

            $this->info("✅ Promo created for: {$product->name} - {$discount}% discount");
        }

        $this->info("\n✨ Promo data created successfully!");
    }
}
