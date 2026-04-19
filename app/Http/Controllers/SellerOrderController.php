<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $productIds = Product::where('user_id', auth()->id())->pluck('id');

        $query = Order::with(['items' => fn($q) => $q->whereIn('product_id', $productIds), 'user'])
            ->whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = [
            'all'        => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->count(),
            'pending'    => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'pending')->count(),
            'processing' => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'processing')->count(),
            'shipped'    => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'shipped')->count(),
            'delivered'  => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'delivered')->count(),
            'cancelled'  => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'cancelled')->count(),
        ];

        return view('seller.orders', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $productIds = Product::where('user_id', auth()->id())->pluck('id');
        abort_unless($order->items()->whereIn('product_id', $productIds)->exists(), 403);

        $order->load(['items.product', 'user']);

        return view('seller.order-detail', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'          => 'required|in:processing,shipped,cancelled',
            'tracking_number' => 'required_if:status,shipped|nullable|string|max:100',
            'courier_name'    => 'required_if:status,shipped|nullable|string|max:100',
        ]);

        $productIds = Product::where('user_id', auth()->id())->pluck('id');
        abort_unless($order->items()->whereIn('product_id', $productIds)->exists(), 403);

        if ($request->status === 'cancelled') {
            abort_if(!in_array($order->status, ['pending', 'processing']), 422);
            $order->load('items.product');
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            $order->update(['status' => 'cancelled', 'cancelled_by' => 'penjual']);
        } else {
            $data = ['status' => $request->status];
            if ($request->status === 'shipped' && $request->filled('tracking_number')) {
                $data['tracking_number'] = $request->tracking_number;
                $data['courier_name']    = $request->courier_name;
            }
            $order->update($data);
        }

        return redirect()->route('seller.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function reviews(Request $request)
    {
        $productIds = Product::where('user_id', auth()->id())->pluck('id');

        $query = Review::with(['user', 'product'])
            ->whereIn('product_id', $productIds)
            ->latest();

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $reviews  = $query->paginate(15)->withQueryString();
        $products = Product::where('user_id', auth()->id())->orderBy('name')->get(['id', 'name']);

        $ratingCounts = Review::whereIn('product_id', $productIds)
            ->selectRaw('rating, count(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        return view('seller.reviews', compact('reviews', 'products', 'ratingCounts'));
    }
}
