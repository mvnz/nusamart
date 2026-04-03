<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ReleaseExpiredOrderStock extends Command
{
    protected $signature   = 'orders:release-expired-stock';
    protected $description = 'Cancel pending orders older than 1 day and restore their stock';

    public function handle(): void
    {
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

        $this->info("Released stock for {$expiredOrders->count()} expired order(s).");
    }
}
