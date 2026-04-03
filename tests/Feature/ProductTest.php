<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    // ===== HELPERS =====

    private function createPenjual(): User
    {
        return User::factory()->penjual()->create();
    }

    private function createCategory(string $name = 'Makanan'): Category
    {
        return Category::create(['name' => $name]);
    }

    private function createProduct(array $attrs = []): Product
    {
        $seller   = $attrs['seller'] ?? $this->createPenjual();
        $category = $attrs['category'] ?? $this->createCategory($attrs['category_name'] ?? 'Makanan');
        unset($attrs['seller'], $attrs['category'], $attrs['category_name']);

        return Product::create(array_merge([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Produk Test',
            'description' => 'Deskripsi produk',
            'price'       => 25000,
            'stock'       => 10,
            'is_active'   => true,
        ], $attrs));
    }

    // ===== PRODUCTS INDEX =====

    public function test_products_index_is_accessible(): void
    {
        $response = $this->get('/produk');
        $response->assertStatus(200);
    }

    public function test_products_index_shows_only_active_products(): void
    {
        $this->createProduct(['name' => 'Produk Aktif', 'is_active' => true]);
        $this->createProduct(['name' => 'Produk Nonaktif', 'is_active' => false]);

        $response = $this->get('/produk');
        $response->assertStatus(200);
        $response->assertSee('Produk Aktif');
        $response->assertDontSee('Produk Nonaktif');
    }

    public function test_products_index_filters_by_category_id(): void
    {
        $catA = $this->createCategory('Makanan');
        $catB = $this->createCategory('Fashion');
        $seller = $this->createPenjual();

        $this->createProduct(['name' => 'Kue Basah', 'category' => $catA, 'seller' => $seller]);
        $this->createProduct(['name' => 'Kemeja Batik', 'category' => $catB, 'seller' => $seller]);

        $response = $this->get('/produk?category_id=' . $catA->id);
        $response->assertStatus(200);
        $response->assertSee('Kue Basah');
        $response->assertDontSee('Kemeja Batik');
    }

    public function test_products_index_filters_by_search(): void
    {
        $this->createProduct(['name' => 'Keripik Singkong']);
        $this->createProduct(['name' => 'Baju Batik', 'category_name' => 'Fashion']);

        $response = $this->get('/produk?search=Keripik');
        $response->assertStatus(200);
        $response->assertSee('Keripik Singkong');
        $response->assertDontSee('Baju Batik');
    }

    public function test_products_index_accessible_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/produk');
        $response->assertStatus(200);
    }

    // ===== PRODUCT SHOW =====

    public function test_product_show_returns_200_for_active_product(): void
    {
        $product = $this->createProduct(['is_active' => true]);

        $response = $this->get('/produk/' . $product->id);
        $response->assertStatus(200);
    }

    public function test_product_show_returns_404_for_inactive_product(): void
    {
        $product = $this->createProduct(['is_active' => false]);

        $response = $this->get('/produk/' . $product->id);
        $response->assertStatus(404);
    }

    public function test_product_show_displays_product_name_and_price(): void
    {
        $product = $this->createProduct([
            'name'  => 'Dodol Garut Spesial',
            'price' => 35000,
        ]);

        $response = $this->get('/produk/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('Dodol Garut Spesial');
    }

    public function test_product_show_passes_is_wishlisted_false_for_guest(): void
    {
        $product = $this->createProduct();

        $response = $this->get('/produk/' . $product->id);
        $response->assertStatus(200);
        $response->assertViewHas('isWishlisted', false);
    }

    // ===== CATEGORIES PAGE =====

    public function test_categories_page_is_accessible(): void
    {
        $response = $this->get('/kategori');
        $response->assertStatus(200);
    }

    public function test_categories_page_shows_existing_categories(): void
    {
        $this->createCategory('Pertanian');
        $this->createCategory('Kerajinan');

        $response = $this->get('/kategori');
        $response->assertStatus(200);
        $response->assertSee('Pertanian');
        $response->assertSee('Kerajinan');
    }

    // ===== SELLER PRODUCT MANAGEMENT =====

    public function test_my_products_requires_authentication(): void
    {
        $response = $this->get('/produk-saya');
        $response->assertRedirect('/login');
    }

    public function test_my_products_requires_penjual_role(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $response = $this->actingAs($pembeli)->get('/produk-saya');
        $response->assertStatus(403);
    }

    public function test_penjual_can_access_my_products(): void
    {
        $penjual = $this->createPenjual();
        $response = $this->actingAs($penjual)->get('/produk-saya');
        $response->assertStatus(200);
    }
}
