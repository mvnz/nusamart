<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReleaseExpiredOrderStock
{
    /**
     * Run at most once per hour (triggered by real web traffic, no scheduler needed).
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Cache::has('expired_stock_released')) {
            Cache::put('expired_stock_released', true, now()->addHour());

            $expiredOrders = Order::with('items.product')
                ->where('status', 'pending')
                ->where('created_at', '<', now()->subDay())
                ->get();

            foreach ($expiredOrders as $order) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
                $order->update(['status' => 'cancelled']);
            }
        }

        return $next($request);
    }
}
