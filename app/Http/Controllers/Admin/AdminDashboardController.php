<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalSellers = User::where('role', 'penjual')->count();
            $totalBuyers = User::where('role', 'pembeli')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalActive = User::where('is_active', true)->count();
            $totalInactive = User::where('is_active', false)->count();
            $newThisMonth = User::whereYear('created_at', now()->year)
                                ->whereMonth('created_at', now()->month)->count();
            $newThisWeek = User::where('created_at', '>=', now()->startOfWeek())->count();
            $recentUsers = User::latest()->take(5)->get();

            $salesDelivered  = (float) Order::where('status', 'delivered')->sum('total_amount');
            $salesProcessing = (float) Order::where('status', 'processing')->sum('total_amount');
            $salesShipped    = (float) Order::where('status', 'shipped')->sum('total_amount');
            $salesPending    = (float) Order::where('status', 'pending')->sum('total_amount');
            $salesCancelled  = (float) Order::where('status', 'cancelled')->sum('total_amount');
            $totalSales      = $salesDelivered + $salesProcessing + $salesShipped + $salesPending + $salesCancelled;

            return view('dashboard', compact(
                'totalUsers', 'totalSellers', 'totalBuyers', 'totalAdmins',
                'totalActive', 'totalInactive', 'newThisMonth', 'newThisWeek',
                'recentUsers',
                'salesDelivered', 'salesProcessing', 'salesShipped', 'salesPending', 'salesCancelled', 'totalSales'
            ));
        }

        $productQuery = Product::active()->with(['seller', 'category']);
        if (request()->filled('search')) {
            $productQuery->where('name', 'like', '%' . request('search') . '%');
        }
        if (request()->filled('category_id')) {
            $productQuery->where('category_id', request('category_id'));
        }

        // ── Seller dashboard ──
        if ($user->role === 'penjual') {
            $productIds = Product::where('user_id', $user->id)->pluck('id');

            $newOrdersCount  = Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'pending')->count();
            $processingCount = Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'processing')->count();
            $shippedCount    = Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'shipped')->count();
            $deliveredCount  = Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))->where('status', 'delivered')->count();

            $activeProductsCount = Product::where('user_id', $user->id)->where('is_active', true)->count();
            $totalProductsCount  = Product::where('user_id', $user->id)->count();

            $totalRevenue = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', fn($q) => $q->where('status', 'delivered'))
                ->sum('subtotal');

            $monthlyRevenue = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', fn($q) => $q->where('status', 'delivered')
                    ->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month))
                ->sum('subtotal');

            $recentOrders = Order::with(['items' => fn($q) => $q->whereIn('product_id', $productIds), 'user'])
                ->whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))
                ->latest()
                ->take(8)
                ->get();

            $latestProducts = Product::where('user_id', $user->id)->latest()->take(5)->get();

            return view('seller.dashboard', compact(
                'newOrdersCount', 'processingCount', 'shippedCount', 'deliveredCount',
                'activeProductsCount', 'totalProductsCount',
                'totalRevenue', 'monthlyRevenue',
                'recentOrders', 'latestProducts'
            ));
        }

        $products = $productQuery->latest()->paginate(12);
        $categories = Category::withCount('products')->get()->filter(fn($c) => $c->products_count > 0)->values();

        return view('dashboard', compact('products', 'categories'));
    }
}
