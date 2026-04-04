<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemModelTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrderItem(array $attrs = []): OrderItem
    {
        $user  = User::factory()->create();
        $order = Order::create([
            'order_number'     => 'ORD-TEST-001',
            'user_id'          => $user->id,
            'total_amount'     => 50000,
            'status'           => 'pending',
            'shipping_name'    => 'Test',
            'shipping_phone'   => '081234567890',
            'shipping_address' => 'Jl. Test',
            'shipping_city'    => 'Kota Test',
            'shipping_province'=> 'Provinsi Test',
            'payment_method'   => 'transfer',
        ]);
        $seller   = User::factory()->penjual()->create();
        $category = Category::create(['name' => 'Kategori']);
        $product  = Product::create([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Produk Test',
            'price'       => 25000,
            'stock'       => 10,
            'is_active'   => true,
        ]);

        return OrderItem::create(array_merge([
            'order_id'     => $order->id,
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'price'        => 25000,
            'quantity'     => 2,
            'subtotal'     => 50000,
        ], $attrs));
    }

    public function test_order_item_has_fillable_attributes(): void
    {
        $item     = new OrderItem();
        $fillable = $item->getFillable();

        foreach (['order_id', 'product_id', 'product_name', 'price', 'quantity', 'subtotal'] as $field) {
            $this->assertContains($field, $fillable);
        }
    }

    public function test_order_item_price_is_cast_to_decimal(): void
    {
        $item = $this->makeOrderItem(['price' => 25000]);
        $this->assertEquals('25000.00', $item->price);
    }

    public function test_order_item_subtotal_is_cast_to_decimal(): void
    {
        $item = $this->makeOrderItem(['subtotal' => 50000]);
        $this->assertEquals('50000.00', $item->subtotal);
    }

    public function test_order_item_belongs_to_order(): void
    {
        $item = $this->makeOrderItem();
        $this->assertInstanceOf(Order::class, $item->order);
    }

    public function test_order_item_belongs_to_product(): void
    {
        $item = $this->makeOrderItem();
        $this->assertInstanceOf(Product::class, $item->product);
    }

    public function test_formatted_price_uses_rupiah_format(): void
    {
        $item = $this->makeOrderItem(['price' => 35000]);
        $this->assertStringStartsWith('Rp ', $item->formatted_price);
        $this->assertStringContainsString('35.000', $item->formatted_price);
    }

    public function test_formatted_subtotal_uses_rupiah_format(): void
    {
        $item = $this->makeOrderItem(['subtotal' => 70000]);
        $this->assertStringStartsWith('Rp ', $item->formatted_subtotal);
        $this->assertStringContainsString('70.000', $item->formatted_subtotal);
    }
}
