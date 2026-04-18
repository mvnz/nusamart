<?php
require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel');

use App\Models\User;
use App\Models\Promo;
use Carbon\Carbon;

// Check munawar account
$munawar = User::where('email', 'munawar@gmail.com')->first();
echo "=== MUNAWAR ACCOUNT ===\n";
if ($munawar) {
    echo "✅ Seller: {$munawar->name} (ID: {$munawar->id})\n";
    $products = $munawar->products()->get();
    echo "   Products: {$products->count()}\n";
    foreach ($products as $p) {
        echo "   - {$p->name} (ID: {$p->id})\n";
        $promo = Promo::where('product_id', $p->id)->first();
        if ($promo) {
            echo "     ✅ Promo exists: {$promo->discount_percentage}% discount\n";
        } else {
            echo "     ❌ No promo yet\n";
        }
    }
} else {
    echo "❌ munawar@gmail.com not found\n";
}

// Check aditya account
echo "\n=== ADITYA ACCOUNT ===\n";
$aditya = User::where('email', 'aditya.budi51@ui.ac.id')->first();
if (!$aditya) {
    $aditya = User::where('name', 'LIKE', '%aditya%')->orWhere('name', 'LIKE', '%Aditya%')->first();
}

if ($aditya) {
    echo "✅ User: {$aditya->name} (ID: {$aditya->id})\n";
    $products = $aditya->products()->get();
    echo "   Products: {$products->count()}\n";
    foreach ($products as $p) {
        echo "   - {$p->name} (ID: {$p->id})\n";
        $promo = Promo::where('product_id', $p->id)->first();
        if ($promo) {
            echo "     ✅ Promo exists: {$promo->discount_percentage}% discount\n";
        } else {
            echo "     ❌ No promo yet\n";
        }
    }
} else {
    echo "❌ aditya.budi51@ui.ac.id or Aditya not found\n";
}

// List all active promos
echo "\n=== ACTIVE PROMOS IN HOMEPAGE ===\n";
$activePromos = Promo::where('is_active', true)
    ->where('start_date', '<=', now())
    ->where('end_date', '>=', now())
    ->with(['product', 'seller'])
    ->get();

echo "Total active promos: {$activePromos->count()}\n";
foreach ($activePromos as $promo) {
    echo "- {$promo->product->name} ({$promo->discount_percentage}%) - Seller: {$promo->seller->name}\n";
}
