<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistManagementTest extends TestCase
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
            'name'        => 'Produk WL',
            'price'       => 20000,
            'stock'       => 5,
            'is_active'   => true,
        ], $attrs));
    }

    // ===== AUTH GUARD =====

    public function test_wishlist_index_requires_authentication(): void
    {
        $this->get('/wishlist')->assertRedirect('/login');
    }

    public function test_wishlist_toggle_requires_authentication(): void
    {
        $product = $this->makeProduct();
        $this->post("/wishlist/{$product->id}")->assertRedirect('/login');
    }

    // ===== INDEX =====

    public function test_buyer_can_view_wishlist(): void
    {
        $buyer = $this->buyer();
        $this->actingAs($buyer)->get('/wishlist')->assertStatus(200);
    }

    public function test_wishlist_shows_wishlisted_products(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['name' => 'Batik Tulis Exclusive']);

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $this->actingAs($buyer)
             ->get('/wishlist')
             ->assertStatus(200)
             ->assertSee('Batik Tulis Exclusive');
    }

    // ===== TOGGLE (ADD) =====

    public function test_toggle_adds_product_to_wishlist(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct();

        $this->actingAs($buyer)
             ->post("/wishlist/{$product->id}")
             ->assertRedirect();

        $this->assertDatabaseHas('wishlists', [
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_toggle_removes_product_if_already_wishlisted(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct();

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $this->actingAs($buyer)
             ->post("/wishlist/{$product->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('wishlists', [
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    // ===== DESTROY =====

    public function test_wishlist_destroy_removes_product(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct();

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $this->actingAs($buyer)
             ->delete("/wishlist/{$product->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('wishlists', [
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_destroy_does_not_remove_others_wishlist(): void
    {
        $buyer1  = $this->buyer();
        $buyer2  = $this->buyer();
        $product = $this->makeProduct();

        Wishlist::create(['user_id' => $buyer2->id, 'product_id' => $product->id]);

        // buyer1 destroys — only affects their own wishlist entries
        $this->actingAs($buyer1)
             ->delete("/wishlist/{$product->id}")
             ->assertRedirect();

        // buyer2's entry should still exist
        $this->assertDatabaseHas('wishlists', [
            'user_id'    => $buyer2->id,
            'product_id' => $product->id,
        ]);
    }

    // ===== IS_WISHLISTED VIEW VAR =====

    public function test_product_show_marks_wishlisted_for_authenticated_user(): void
    {
        $buyer   = $this->buyer();
        $product = $this->makeProduct(['name' => 'Tas Rotan']);

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $this->actingAs($buyer)
             ->get("/produk/{$product->id}")
             ->assertStatus(200)
             ->assertViewHas('isWishlisted', true);
    }
}
