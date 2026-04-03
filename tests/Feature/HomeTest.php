<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    // ===== HELPERS =====

    private function createPenjual(array $attrs = []): User
    {
        return User::factory()->penjual()->create($attrs);
    }

    private function createCategory(string $name = 'Makanan'): Category
    {
        return Category::create(['name' => $name]);
    }

    private function createProduct(array $attrs = []): Product
    {
        $seller   = $this->createPenjual();
        $category = $this->createCategory($attrs['category_name'] ?? 'Makanan');
        unset($attrs['category_name']);

        return Product::create(array_merge([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Produk Test',
            'description' => 'Deskripsi',
            'price'       => 10000,
            'stock'       => 10,
            'is_active'   => true,
        ], $attrs));
    }

    private function createOrder(array $attrs = []): Order
    {
        $buyer = User::factory()->create();
        return Order::create(array_merge([
            'order_number'   => 'ORD-' . uniqid(),
            'user_id'        => $buyer->id,
            'total_amount'   => 50000,
            'status'         => 'pending',
            'shipping_name'  => 'Test User',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test',
            'shipping_city'    => 'Jakarta',
            'shipping_province' => 'DKI Jakarta',
            'payment_method'   => 'transfer',
        ], $attrs));
    }

    // ===== HOME PAGE =====

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_passes_required_view_variables(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('statsProductCount');
        $response->assertViewHas('statsPenjualCount');
        $response->assertViewHas('statsOrderCount');
        $response->assertViewHas('featuredProducts');
        $response->assertViewHas('promoBanners');
        $response->assertViewHas('flashSaleProducts');
        $response->assertViewHas('tabProducts');
    }

    public function test_home_stats_product_count_counts_only_active_products(): void
    {
        $this->createProduct(['is_active' => true]);
        $this->createProduct(['is_active' => true, 'category_name' => 'Minuman']);
        $this->createProduct(['is_active' => false, 'category_name' => 'Fashion']);

        $response = $this->get('/');
        $response->assertViewHas('statsProductCount', 2);
    }

    public function test_home_stats_penjual_count_counts_only_active_penjual(): void
    {
        $this->createPenjual(['is_active' => true]);
        $this->createPenjual(['is_active' => true]);
        $this->createPenjual(['is_active' => false]);
        User::factory()->create(['role' => 'pembeli']); // pembeli, should not count

        $response = $this->get('/');
        $response->assertViewHas('statsPenjualCount', 2);
    }

    public function test_home_stats_order_count_counts_all_orders(): void
    {
        $this->createOrder();
        $this->createOrder();
        $this->createOrder();

        $response = $this->get('/');
        $response->assertViewHas('statsOrderCount', 3);
    }

    public function test_home_promo_banners_only_include_categories_with_active_products(): void
    {
        // Category with active products
        $catWithProducts = $this->createCategory('Kerajinan');
        $seller = $this->createPenjual();
        Product::create([
            'user_id'     => $seller->id,
            'category_id' => $catWithProducts->id,
            'name'        => 'Produk Kerajinan',
            'description' => 'Desc',
            'price'       => 20000,
            'stock'       => 5,
            'is_active'   => true,
        ]);

        // Category with no products
        $this->createCategory('Kategori Kosong');

        $response = $this->get('/');
        $response->assertStatus(200);

        $banners = $response->viewData('promoBanners');
        $bannerCategoryIds = collect($banners)->pluck('id')->toArray();

        $this->assertNotContains(
            Category::where('name', 'Kategori Kosong')->first()->id,
            $bannerCategoryIds
        );
    }

    public function test_home_tab_products_have_for_user_rekomendasi_populer_keys(): void
    {
        $response = $this->get('/');
        $tabProducts = $response->viewData('tabProducts');

        $this->assertArrayHasKey('for_user', $tabProducts);
        $this->assertArrayHasKey('rekomendasi', $tabProducts);
        $this->assertArrayHasKey('populer', $tabProducts);
    }

    public function test_home_page_accessible_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_accessible_for_seller(): void
    {
        $seller = $this->createPenjual();
        $response = $this->actingAs($seller)->get('/');
        $response->assertStatus(200);
    }
}
