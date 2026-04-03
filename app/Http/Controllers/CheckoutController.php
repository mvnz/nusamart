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
            'payment_method'    => 'required|in:transfer,virtual_account',
            'va_bank'           => 'required_if:payment_method,virtual_account|nullable|in:bca,mandiri,bni,bri',
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

        // Generate unique code (3-digit suffix) for transfer bank identification
        $uniqueCode = null;
        if ($request->payment_method === 'transfer') {
            $uniqueCode = rand(1, 999);
        }

        // Generate VA number if payment method is virtual_account
        $vaNumber = null;
        $vaBank   = null;
        if ($request->payment_method === 'virtual_account') {
            $vaBank = $request->va_bank;
            $prefix = match($vaBank) {
                'bca'     => '88008',
                'mandiri' => '88855',
                'bni'     => '98811',
                'bri'     => '26215',
                default   => '88000',
            };
            $vaNumber = $prefix . str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        }

        // Buat order
        $order = Order::create([
            'order_number'           => 'NM-' . strtoupper(Str::random(8)),
            'user_id'                => auth()->id(),
            'total_amount'           => $total,
            'status'                 => 'pending',
            'shipping_name'          => $request->shipping_name,
            'shipping_phone'         => $request->shipping_phone,
            'shipping_address'       => $request->shipping_address,
            'shipping_city'          => $request->shipping_city,
            'shipping_province'      => $request->shipping_province,
            'payment_method'         => $request->payment_method,
            'unique_code'            => $uniqueCode,
            'virtual_account_number' => $vaNumber,
            'va_bank'                => $vaBank,
            'notes'                  => $request->notes,
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
