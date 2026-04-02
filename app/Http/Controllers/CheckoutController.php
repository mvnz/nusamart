<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $user  = auth()->user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name'     => 'required|string|max:255',
            'shipping_phone'    => 'required|string|max:20',
            'shipping_address'  => 'required|string|max:500',
            'shipping_city'     => 'required|string|max:100',
            'shipping_province' => 'required|string|max:100',
            'payment_method'    => 'required|in:transfer',
            'notes'             => 'nullable|string|max:500',
        ]);

        $cartItems = auth()->user()->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi stok untuk semua item
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok produk '{$item->product->name}' tidak mencukupi. Tersisa: {$item->product->stock}.");
            }
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        // Buat order
        $order = Order::create([
            'order_number'      => 'NM-' . strtoupper(Str::random(8)),
            'user_id'           => auth()->id(),
            'total_amount'      => $total,
            'status'            => 'pending',
            'shipping_name'     => $request->shipping_name,
            'shipping_phone'    => $request->shipping_phone,
            'shipping_address'  => $request->shipping_address,
            'shipping_city'     => $request->shipping_city,
            'shipping_province' => $request->shipping_province,
            'payment_method'    => $request->payment_method,
            'notes'             => $request->notes,
        ]);

        // Buat order items dan kurangi stok
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'price'        => $item->product->price,
                'quantity'     => $item->quantity,
                'subtotal'     => $item->quantity * $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);
        }

        // Kosongkan keranjang
        auth()->user()->carts()->delete();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
