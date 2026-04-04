<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartModelTest extends TestCase
{
    use RefreshDatabase;

    private function createUserAndProduct(int $price = 20000, int $stock = 10): array
    {
        $seller   = User::factory()->penjual()->create();
        $category = Category::create(['name' => 'Elektronik']);
        $product  = Product::create([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Produk Test',
            'price'       => $price,
            'stock'       => $stock,
            'is_active'   => true,
        ]);
        $buyer = User::factory()->create(['role' => 'pembeli']);

        return [$buyer, $product];
    }

    public function test_cart_has_fillable_attributes(): void
    {
        $cart     = new Cart();
        $fillable = $cart->getFillable();

        $this->assertContains('user_id', $fillable);
        $this->assertContains('product_id', $fillable);
        $this->assertContains('quantity', $fillable);
    }

    public function test_cart_belongs_to_user(): void
    {
        [$buyer, $product] = $this->createUserAndProduct();

        $cart = Cart::create([
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $this->assertInstanceOf(User::class, $cart->user);
        $this->assertEquals($buyer->id, $cart->user->id);
    }

    public function test_cart_belongs_to_product(): void
    {
        [$buyer, $product] = $this->createUserAndProduct();

        $cart = Cart::create([
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $this->assertInstanceOf(Product::class, $cart->product);
        $this->assertEquals($product->id, $cart->product->id);
    }

    public function test_subtotal_accessor_multiplies_quantity_by_price(): void
    {
        [$buyer, $product] = $this->createUserAndProduct(price: 15000);

        $cart = Cart::create([
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 3,
        ]);

        $cart->load('product');
        $this->assertEquals(45000.0, $cart->subtotal);
    }

    public function test_cart_can_be_created_in_database(): void
    {
        [$buyer, $product] = $this->createUserAndProduct();

        Cart::create([
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);
    }
}
