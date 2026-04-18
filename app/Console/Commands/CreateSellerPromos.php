<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateSellerPromos extends Command
{
    protected $signature = 'promo:create-seller {email?}';
    protected $description = 'Create promos for seller';

    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $sellers = User::where('email', $email)->get();
        } else {
            $sellers = User::whereIn('email', ['munawar@gmail.com', 'aditya.budi@ui.ac.id'])->get();
        }

        if ($sellers->isEmpty()) {
            $this->error('No sellers found');
            return;
        }

        foreach ($sellers as $seller) {
            $this->info("\n📦 Creating promos for: {$seller->name} ({$seller->email})");
            
            $products = $seller->products()->where('is_active', true)->limit(5)->get();
            
            if ($products->isEmpty()) {
                $this->warn('  No active products');
                continue;
            }

            foreach ($products as $i => $product) {
                // Different discount percentages for each seller
                if ($seller->email === 'munawar@gmail.com') {
                    $discount = 10 + ($i * 3); // 10, 13, 16, 19, 22
                } else {
                    $discount = 12 + ($i * 4); // 12, 16, 20, 24, 28
                }
                
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
                    'used_quota' => rand(5, 30),
                    'is_active' => true,
                ]);

                $this->info("  ✅ {$product->name} - {$discount}% discount (Rp " . number_format($promoPrice, 0, ',', '.') . ")");
            }
        }

        $this->info("\n✨ Done!");
    }
}
