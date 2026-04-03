<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product.seller')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Produk dihapus dari wishlist.');
        }

        Wishlist::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Produk ditambahkan ke wishlist!');
    }

    public function destroy(Product $product)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
