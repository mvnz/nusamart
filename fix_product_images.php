<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

$products = Product::whereNotNull('image')
    ->where('image', 'like', 'https://%')
    ->get();

echo "Found " . $products->count() . " products with external URLs\n";

foreach ($products as $product) {
    try {
        $url = $product->image;
        echo "Downloading image for: {$product->name} from {$url}... ";
        
        // Download image
        $response = Http::timeout(30)->get($url);
        
        if ($response->successful()) {
            // Save to local storage
            $filename = 'products/product_' . $product->id . '.jpg';
            Storage::disk('public')->put($filename, $response->body());
            
            // Update product with local path
            $product->update(['image' => $filename]);
            
            echo "OK\n";
        } else {
            echo "FAILED (HTTP {$response->status()})\n";
        }
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}

echo "Done!\n";
