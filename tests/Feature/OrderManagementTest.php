<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    // ===== HELPERS =====

    private function buyer(): User
    {
        return User::factory()->create(['role' => 'pembeli']);
    }

    private function makeOrder(User $buyer, array $attrs = []): Order
    {
        return Order::create(array_merge([
            'order_number'     => 'ORD-' . uniqid(),
            'user_id'          => $buyer->id,
            'total_amount'     => 100000,
            'status'           => 'pending',
            'shipping_name'    => 'Budi Santoso',
            'shipping_phone'   => '081234567890',
            'shipping_address' => 'Jl. Merdeka No.1',
            'shipping_city'    => 'Bandung',
            'shipping_province'=> 'Jawa Barat',
            'payment_method'   => 'transfer',
        ], $attrs));
    }

    private function addItem(Order $order, string $name = 'Produk Test'): OrderItem
    {
        $seller   = User::factory()->penjual()->create();
        $category = Category::create(['name' => 'Test ' . uniqid()]);
        $product  = Product::create([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => $name,
            'price'       => 50000,
            'stock'       => 10,
            'is_active'   => true,
        ]);

        return OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => $product->id,
            'product_name' => $name,
            'price'        => 50000,
            'quantity'     => 2,
            'subtotal'     => 100000,
        ]);
    }

    // ===== AUTH GUARD =====

    public function test_orders_index_requires_authentication(): void
    {
        $this->get('/pesanan')->assertRedirect('/login');
    }

    public function test_order_show_requires_authentication(): void
    {
        $buyer = $this->buyer();
        $order = $this->makeOrder($buyer);
        $this->get("/pesanan/{$order->id}")->assertRedirect('/login');
    }

    // ===== INDEX =====

    public function test_buyer_can_view_orders_index(): void
    {
        $buyer = $this->buyer();
        $this->actingAs($buyer)->get('/pesanan')->assertStatus(200);
    }

    public function test_orders_index_shows_user_own_orders(): void
    {
        $buyer1 = $this->buyer();
        $buyer2 = $this->buyer();
        $order1 = $this->makeOrder($buyer1, ['order_number' => 'ORD-BUYER1']);
        $order2 = $this->makeOrder($buyer2, ['order_number' => 'ORD-BUYER2']);

        $this->addItem($order1, 'Kain Batik');
        $this->addItem($order2, 'Keramik Dijual');

        $this->actingAs($buyer1)
             ->get('/pesanan')
             ->assertStatus(200)
             ->assertSee('ORD-BUYER1')
             ->assertDontSee('ORD-BUYER2');
    }

    public function test_orders_index_filters_by_status_berlangsung(): void
    {
        $buyer  = $this->buyer();
        $active = $this->makeOrder($buyer, ['order_number' => 'ORD-PEND', 'status' => 'pending']);
        $done   = $this->makeOrder($buyer, ['order_number' => 'ORD-DONE', 'status' => 'delivered']);

        $this->addItem($active, 'A');
        $this->addItem($done, 'B');

        $this->actingAs($buyer)
             ->get('/pesanan?status=berlangsung')
             ->assertStatus(200)
             ->assertSee('ORD-PEND')
             ->assertDontSee('ORD-DONE');
    }

    public function test_orders_index_filters_by_status_selesai(): void
    {
        $buyer    = $this->buyer();
        $pending  = $this->makeOrder($buyer, ['order_number' => 'ORD-PEND', 'status' => 'pending']);
        $delivered= $this->makeOrder($buyer, ['order_number' => 'ORD-DONE', 'status' => 'delivered']);

        $this->addItem($pending, 'A');
        $this->addItem($delivered, 'B');

        $this->actingAs($buyer)
             ->get('/pesanan?status=selesai')
             ->assertStatus(200)
             ->assertSee('ORD-DONE')
             ->assertDontSee('ORD-PEND');
    }

    // ===== SHOW =====

    public function test_buyer_can_view_own_order(): void
    {
        $buyer = $this->buyer();
        $order = $this->makeOrder($buyer);
        $this->addItem($order);

        $this->actingAs($buyer)
             ->get("/pesanan/{$order->id}")
             ->assertStatus(200);
    }

    public function test_buyer_cannot_view_another_users_order(): void
    {
        $buyer1 = $this->buyer();
        $buyer2 = $this->buyer();
        $order  = $this->makeOrder($buyer2);

        $this->actingAs($buyer1)
             ->get("/pesanan/{$order->id}")
             ->assertStatus(403);
    }

    // ===== MARK RECEIVED =====

    public function test_buyer_can_mark_shipped_order_as_received(): void
    {
        $buyer = $this->buyer();
        $order = $this->makeOrder($buyer, ['status' => 'shipped']);

        $this->actingAs($buyer)
             ->patch("/pesanan/{$order->id}/terima")
             ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'delivered',
        ]);
    }

    public function test_buyer_cannot_mark_pending_order_as_received(): void
    {
        $buyer = $this->buyer();
        $order = $this->makeOrder($buyer, ['status' => 'pending']);

        $this->actingAs($buyer)
             ->patch("/pesanan/{$order->id}/terima")
             ->assertStatus(422);
    }

    public function test_buyer_cannot_mark_another_users_order_as_received(): void
    {
        $buyer1 = $this->buyer();
        $buyer2 = $this->buyer();
        $order  = $this->makeOrder($buyer2, ['status' => 'shipped']);

        $this->actingAs($buyer1)
             ->patch("/pesanan/{$order->id}/terima")
             ->assertStatus(403);
    }
}
