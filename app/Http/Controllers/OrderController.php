<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->orders()->with('items.product.seller')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('items', fn($i) => $i->where('product_name', 'like', '%' . $request->search . '%'));
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $statusMap = [
                'berlangsung' => ['pending', 'processing', 'shipped'],
                'selesai'     => ['delivered'],
                'dibatalkan'  => ['cancelled'],
            ];
            if (isset($statusMap[$request->status])) {
                $query->whereIn('status', $statusMap[$request->status]);
            } else {
                $query->where('status', $request->status);
            }
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if((int)$order->user_id !== (int)auth()->id(), 403);

        $order->load('items.product');

        $reviewedProductIds = \App\Models\Review::where('user_id', auth()->id())
            ->whereIn('product_id', $order->items->pluck('product_id'))
            ->pluck('product_id')
            ->toArray();

        return view('orders.show', compact('order', 'reviewedProductIds'));
    }

    public function markReceived(Order $order)
    {
        abort_if((int)$order->user_id !== (int)auth()->id(), 403);
        abort_if($order->status !== 'shipped', 422);

        $order->update(['status' => 'delivered']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan telah dikonfirmasi diterima. Terima kasih!');
    }

    public function cancel(Order $order)
    {
        abort_if((int)$order->user_id !== (int)auth()->id(), 403);
        abort_if($order->status !== 'pending', 422);

        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update(['status' => 'cancelled', 'cancelled_by' => 'pembeli']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan.');
    }

    public function track(Order $order)
    {
        abort_if((int)$order->user_id !== (int)auth()->id(), 403);

        $apiKey = config('services.binderbyte.key');
        $awb    = $order->tracking_number;

        if (!$awb) {
            return response()->json(['error' => 'Nomor resi tidak tersedia.'], 422);
        }

        if (!$apiKey) {
            return response()->json(['error' => 'API tracking belum dikonfigurasi.'], 503);
        }

        // Map nama kurir ke kode BinderByte
        $courierMap = [
            'jne'          => 'jne',
            'j&t express'  => 'jet',
            'j&t'          => 'jet',
            'sicepat'      => 'sicepat',
            'anteraja'     => 'anteraja',
            'pos indonesia' => 'pos',
            'pos'          => 'pos',
            'ninja xpress' => 'ninja',
            'ninja'        => 'ninja',
            'lion parcel'  => 'lion',
            'tiki'         => 'tiki',
            'gosend'       => 'gosend',
            'grabexpress'  => 'grab',
        ];

        $courierKey = 'auto';
        if ($order->courier_name) {
            $courierKey = $courierMap[strtolower($order->courier_name)] ?? 'auto';
        }

        $params = [
            'api_key' => $apiKey,
            'courier' => $courierKey,
            'awb'     => $awb,
        ];

        // JNE butuh 5 digit terakhir nomor HP untuk history lengkap
        if ($courierKey === 'jne' && $order->shipping_phone) {
            $phone = preg_replace('/\D/', '', $order->shipping_phone);
            $params['number'] = substr($phone, -5);
        }

        $response = Http::timeout(10)->get('https://api.binderbyte.com/v1/track', $params);

        $data = $response->json();

        if (!$response->successful() || ($data['status'] ?? null) !== 200) {
            $msg = $data['message'] ?? 'Gagal mengambil data tracking (HTTP ' . $response->status() . ').';
            return response()->json(['error' => $msg], 422);
        }

        return response()->json($data['data']);
    }
}
