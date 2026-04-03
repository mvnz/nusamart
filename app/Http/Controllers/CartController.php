<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->carts()->with('product.seller')->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->stock < 1) {
            return back()->with('error', 'Produk ini sudah habis.');
        }

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stock . ').');
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Total di keranjang melebihi stok yang tersedia (' . $product->stock . ').');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $cart->product->stock . ').');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $cart->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        auth()->user()->carts()->delete();

        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function buyNow(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        if ($product->stock < 1) {
            return back()->with('error', 'Produk ini sudah habis.');
        }

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stock . ').');
        }

        // Replace cart with only this item so checkout goes straight to this product
        Cart::where('user_id', auth()->id())->delete();
        Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
        ]);

        return redirect()->route('checkout.index');
    }
}
