<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartManagementTest extends TestCase
{
    use RefreshDatabase;

    // ===== HELPERS =====

    private function buyer(): User
    {
        return User::factory()->create(['role' => 'pembeli']);
    }

    private function makeProduct(array $attrs = []): Product
    {
        $seller   = User::factory()->penjual()->create();
        $category = Category::create(['name' => 'Test']);

        return Product::create(array_merge([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Produk Test',
            'price'       => 25000,
            'stock'       => 10,
            'is_active'   => true,
        ], $attrs));
    }

    // ===== AUTH GUARD =====

    public function test_cart_index_requires_authentication(): void
    {
        $this->get('/keranjang')->assertRedirect('/login');
    }

    public function test_add_to_cart_requires_authentication(): void
    {
        $product = $this->makeProduct();
        $this->post("/keranjang/{$product->id}", ['quantity' => 1])->assertRedirect('/login');
    }

    // ===== INDEX =====

    public function test_buyer_can_view_cart(): void
    {
        $buyer = $this->buyer();
        $this->actingAs($buyer)->get('/keranjang')->assertStatus(200);
    }

    public function test_cart_shows_items_for_current_user(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['name' => 'Keripik Singkong']);

        Cart::create([
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $this->actingAs($buyer)
             ->get('/keranjang')
             ->assertStatus(200)
             ->assertSee('Keripik Singkong');
    }

    // ===== ADD TO CART =====

    public function test_buyer_can_add_product_to_cart(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct();

        $this->actingAs($buyer)
             ->post("/keranjang/{$product->id}", ['quantity' => 2])
             ->assertRedirect();

        $this->assertDatabaseHas('carts', [
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);
    }

    public function test_add_to_cart_increments_existing_entry(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['stock' => 10]);

        Cart::create(['user_id' => $buyer->id, 'product_id' => $product->id, 'quantity' => 3]);

        $this->actingAs($buyer)
             ->post("/keranjang/{$product->id}", ['quantity' => 2]);

        $this->assertDatabaseHas('carts', [
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
            'quantity'   => 5,
        ]);
        $this->assertDatabaseCount('carts', 1);
    }

    public function test_add_to_cart_rejects_out_of_stock_product(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['stock' => 0]);

        $this->actingAs($buyer)
             ->post("/keranjang/{$product->id}", ['quantity' => 1])
             ->assertRedirect()
             ->assertSessionHas('error');

        $this->assertDatabaseMissing('carts', ['product_id' => $product->id]);
    }

    public function test_add_to_cart_rejects_quantity_exceeding_stock(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['stock' => 5]);

        $this->actingAs($buyer)
             ->post("/keranjang/{$product->id}", ['quantity' => 10])
             ->assertRedirect()
             ->assertSessionHas('error');
    }

    // ===== UPDATE =====

    public function test_buyer_can_update_cart_quantity(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['stock' => 10]);
        $cart    = Cart::create(['user_id' => $buyer->id, 'product_id' => $product->id, 'quantity' => 2]);

        $this->actingAs($buyer)
             ->patch("/keranjang/{$cart->id}", ['quantity' => 4])
             ->assertRedirect();

        $this->assertDatabaseHas('carts', ['id' => $cart->id, 'quantity' => 4]);
    }

    public function test_buyer_cannot_update_anothers_cart(): void
    {
        $buyer   = $this->buyer();
        $other   = $this->buyer();
        $product = $this->makeProduct(['stock' => 10]);
        $cart    = Cart::create(['user_id' => $other->id, 'product_id' => $product->id, 'quantity' => 2]);

        $this->actingAs($buyer)
             ->patch("/keranjang/{$cart->id}", ['quantity' => 1])
             ->assertStatus(403);
    }

    // ===== REMOVE =====

    public function test_buyer_can_remove_cart_item(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct();
        $cart    = Cart::create(['user_id' => $buyer->id, 'product_id' => $product->id, 'quantity' => 1]);

        $this->actingAs($buyer)
             ->delete("/keranjang/{$cart->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    public function test_buyer_cannot_remove_anothers_cart_item(): void
    {
        $buyer   = $this->buyer();
        $other   = $this->buyer();
        $product = $this->makeProduct();
        $cart    = Cart::create(['user_id' => $other->id, 'product_id' => $product->id, 'quantity' => 1]);

        $this->actingAs($buyer)
             ->delete("/keranjang/{$cart->id}")
             ->assertStatus(403);
    }

    // ===== CLEAR =====

    public function test_buyer_can_clear_cart(): void
    {
        $buyer    = $this->buyer();
        $product1 = $this->makeProduct(['name' => 'Produk 1']);
        $product2 = $this->makeProduct(['name' => 'Produk 2']);

        Cart::create(['user_id' => $buyer->id, 'product_id' => $product1->id, 'quantity' => 1]);
        Cart::create(['user_id' => $buyer->id, 'product_id' => $product2->id, 'quantity' => 2]);

        $this->actingAs($buyer)
             ->delete('/keranjang')
             ->assertRedirect();

        $this->assertDatabaseMissing('carts', ['user_id' => $buyer->id]);
    }
}
