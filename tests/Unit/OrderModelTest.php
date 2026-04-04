<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(array $attrs = []): Order
    {
        $user = User::factory()->create();
        return Order::create(array_merge([
            'order_number'    => 'ORD-' . now()->format('YmdHis'),
            'user_id'         => $user->id,
            'total_amount'    => 100000,
            'status'          => 'pending',
            'shipping_name'   => 'Budi Santoso',
            'shipping_phone'  => '081234567890',
            'shipping_address'=> 'Jl. Merdeka No.1',
            'shipping_city'   => 'Bandung',
            'shipping_province' => 'Jawa Barat',
            'payment_method'  => 'transfer',
        ], $attrs));
    }

    public function test_order_has_fillable_attributes(): void
    {
        $order    = new Order();
        $fillable = $order->getFillable();

        foreach (['order_number', 'user_id', 'total_amount', 'status',
                  'shipping_name', 'shipping_phone', 'shipping_address',
                  'shipping_city', 'shipping_province', 'payment_method',
                  'courier_name', 'tracking_number', 'notes'] as $field) {
            $this->assertContains($field, $fillable);
        }
    }

    public function test_order_total_amount_is_cast_to_decimal(): void
    {
        $order = $this->makeOrder(['total_amount' => 75000]);
        $this->assertEquals('75000.00', $order->total_amount);
    }

    public function test_order_belongs_to_user(): void
    {
        $order = $this->makeOrder();
        $this->assertInstanceOf(User::class, $order->user);
    }

    public function test_order_has_many_items(): void
    {
        $order = $this->makeOrder();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $order->items());
    }

    public function test_status_label_pending(): void
    {
        $order = $this->makeOrder(['status' => 'pending']);
        $this->assertEquals('Menunggu Konfirmasi', $order->status_label);
    }

    public function test_status_label_processing(): void
    {
        $order = $this->makeOrder(['status' => 'processing']);
        $this->assertEquals('Diproses', $order->status_label);
    }

    public function test_status_label_shipped(): void
    {
        $order = $this->makeOrder(['status' => 'shipped']);
        $this->assertEquals('Dikirim', $order->status_label);
    }

    public function test_status_label_delivered(): void
    {
        $order = $this->makeOrder(['status' => 'delivered']);
        $this->assertEquals('Selesai', $order->status_label);
    }

    public function test_status_label_cancelled(): void
    {
        $order = $this->makeOrder(['status' => 'cancelled']);
        $this->assertEquals('Dibatalkan', $order->status_label);
    }

    public function test_status_color_pending(): void
    {
        $order = $this->makeOrder(['status' => 'pending']);
        $this->assertEquals('#f59e0b', $order->status_color);
    }

    public function test_status_color_delivered(): void
    {
        $order = $this->makeOrder(['status' => 'delivered']);
        $this->assertEquals('#10b981', $order->status_color);
    }

    public function test_status_color_cancelled(): void
    {
        $order = $this->makeOrder(['status' => 'cancelled']);
        $this->assertEquals('#ef4444', $order->status_color);
    }

    public function test_formatted_total_uses_rupiah_format(): void
    {
        $order = $this->makeOrder(['total_amount' => 150000]);
        $this->assertStringStartsWith('Rp ', $order->formatted_total);
        $this->assertStringContainsString('150.000', $order->formatted_total);
    }

    public function test_transfer_amount_adds_unique_code(): void
    {
        $order = $this->makeOrder(['total_amount' => 100000, 'unique_code' => 123]);
        $this->assertEquals(100123, $order->transfer_amount);
    }

    public function test_transfer_amount_without_unique_code(): void
    {
        $order = $this->makeOrder(['total_amount' => 50000, 'unique_code' => null]);
        $this->assertEquals(50000, $order->transfer_amount);
    }

    public function test_formatted_transfer_amount_uses_rupiah_format(): void
    {
        $order = $this->makeOrder(['total_amount' => 200000, 'unique_code' => 456]);
        $this->assertStringStartsWith('Rp ', $order->formatted_transfer_amount);
        $this->assertStringContainsString('200.456', $order->formatted_transfer_amount);
    }
}
