<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
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
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->getDisplayPrice());
        $user  = auth()->user();

        return view('checkout.index', compact('cartItems', 'itemsBySeller', 'total', 'user'));
    }

    /**
     * AJAX: validate voucher code and return discount info.
     */
    public function validateVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string', 'total' => 'required|numeric|min:0']);

        $voucher = Voucher::where('code', strtoupper(trim($request->code)))->first();

        if (! $voucher) {
            return response()->json(['valid' => false, 'message' => 'Kode voucher tidak ditemukan.']);
        }
        if (! $voucher->isActive()) {
            return response()->json(['valid' => false, 'message' => 'Voucher tidak aktif atau sudah kedaluwarsa.']);
        }
        if ($voucher->isQuotaFull()) {
            return response()->json(['valid' => false, 'message' => 'Kuota voucher sudah habis.']);
        }
        if ($voucher->min_purchase && $request->total < $voucher->min_purchase) {
            return response()->json(['valid' => false, 'message' => 'Minimum pembelian Rp ' . number_format($voucher->min_purchase, 0, ',', '.') . ' untuk memakai voucher ini.']);
        }

        $discount = $voucher->calculateDiscount((float) $request->total);

        return response()->json([
            'valid'        => true,
            'discount'     => $discount,
            'discount_fmt' => 'Rp ' . number_format($discount, 0, ',', '.'),
            'message'      => 'Voucher berhasil diterapkan! Diskon ' . ($voucher->discount_type === 'percentage' ? $voucher->discount_value . '%' : 'Rp ' . number_format($voucher->discount_value, 0, ',', '.')) . '.',
        ]);
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
            'voucher_code'      => 'nullable|string|max:50',
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

        // Resolve voucher
        $voucher        = null;
        $totalDiscount  = 0;
        $voucherCode    = null;

        if ($request->filled('voucher_code')) {
            $voucher = Voucher::where('code', strtoupper(trim($request->voucher_code)))->first();

            if ($voucher && $voucher->isActive() && ! $voucher->isQuotaFull()) {
                $grandTotal    = $cartItems->sum(fn($item) => $item->quantity * $item->product->getDisplayPrice());
                if (! $voucher->min_purchase || $grandTotal >= $voucher->min_purchase) {
                    $totalDiscount = $voucher->calculateDiscount((float) $grandTotal);
                    $voucherCode   = $voucher->code;
                } else {
                    $voucher = null; // discard — min purchase not met
                }
            } else {
                $voucher = null; // discard invalid
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
        $grandTotal    = $cartItems->sum(fn($item) => $item->quantity * $item->product->getDisplayPrice());
        $orders = [];
        $remainingDiscount = $totalDiscount;

        foreach ($itemsBySeller as $sellerId => $sellerItems) {
            $sellerSubtotal = $sellerItems->sum(fn($item) => $item->quantity * $item->product->getDisplayPrice());

            // Distribute discount proportionally across sellers; last seller absorbs rounding
            $sellerDiscount = 0;
            if ($totalDiscount > 0 && $grandTotal > 0) {
                $isLastSeller   = ($sellerId === $itemsBySeller->keys()->last());
                $sellerDiscount = $isLastSeller
                    ? $remainingDiscount
                    : round($totalDiscount * ($sellerSubtotal / $grandTotal), 2);
                $remainingDiscount -= $sellerDiscount;
            }

            $sellerTotal = max(0, $sellerSubtotal - $sellerDiscount);
            $uniqueCode  = ($request->payment_method === 'transfer') ? rand(1, 999) : null;

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
                'voucher_code'           => $voucherCode,
                'discount_amount'        => $sellerDiscount,
            ]);

            foreach ($sellerItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->getDisplayPrice(),
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->quantity * $item->product->getDisplayPrice(),
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $orders[] = $order;
        }

        // Mark voucher as used
        if ($voucher) {
            $voucher->increment('used_count');
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

