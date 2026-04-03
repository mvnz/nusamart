<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
App\Models\Product::whereNull('image')->get()->each(function($p) {
    $path = 'products/product_' . $p->id . '.jpg';
    if (file_exists(storage_path('app/public/' . $path))) {
        $p->update(['image' => $path]);
        echo 'Updated: ' . $p->id . ' - ' . $p->name . PHP_EOL;
    } else {
        echo 'File missing: ' . $p->id . ' - ' . $p->name . PHP_EOL;
    }
});
echo 'Done' . PHP_EOL;
