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
        $cartItems = auth()->user()->carts()->with('product.seller')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Kelompokkan per penjual
        $itemsBySeller = $cartItems->groupBy(fn($item) => $item->product->user_id);
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $user  = auth()->user();

        return view('checkout.index', compact('cartItems', 'itemsBySeller', 'total', 'user'));
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

        $cartItems = auth()->user()->carts()->with('product.seller')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi stok semua item
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok produk '{$item->product->name}' tidak mencukupi. Tersisa: {$item->product->stock}.");
            }
        }

        // Generate VA sekali untuk semua order (nomor sama, tapi setiap order punya total berbeda)
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

        // Kelompokkan per penjual → buat 1 order per penjual
        $itemsBySeller = $cartItems->groupBy(fn($item) => $item->product->user_id);
        $orders = [];

        foreach ($itemsBySeller as $sellerId => $sellerItems) {
            $sellerTotal = $sellerItems->sum(fn($item) => $item->quantity * $item->product->price);

            $uniqueCode = ($request->payment_method === 'transfer') ? rand(1, 999) : null;

            $order = Order::create([
                'order_number'           => 'NM-' . strtoupper(Str::random(8)),
                'user_id'                => auth()->id(),
                'total_amount'           => $sellerTotal,
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

            foreach ($sellerItems as $item) {
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

            $orders[] = $order;
        }

        // Kosongkan keranjang
        auth()->user()->carts()->delete();

        // Jika hanya 1 penjual → tampilkan detail order, jika lebih → daftar pesanan
        if (count($orders) === 1) {
            return redirect()->route('orders.show', $orders[0])
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        }

        return redirect()->route('orders.index')
            ->with('success', count($orders) . ' pesanan berhasil dibuat dari ' . count($orders) . ' toko berbeda! Silakan lakukan pembayaran.');
    }
}
