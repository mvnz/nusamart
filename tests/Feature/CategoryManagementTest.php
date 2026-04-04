<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    // ===== ACCESS CONTROL =====

    public function test_guest_cannot_access_categories(): void
    {
        $this->get('/admin/categories')->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_categories(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'pembeli']))
            ->get('/admin/categories')
            ->assertStatus(403);
    }

    public function test_admin_can_access_categories(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/categories')
            ->assertStatus(200);
    }

    // ===== CREATE =====

    public function test_admin_can_create_category(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/categories', ['name' => 'Elektronik'])
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', ['name' => 'Elektronik', 'is_active' => true]);
    }

    public function test_category_name_must_be_unique(): void
    {
        Category::create(['name' => 'Pakaian']);

        $this->actingAs($this->admin())
            ->post('/admin/categories', ['name' => 'Pakaian'])
            ->assertSessionHasErrors('name');
    }

    public function test_category_name_is_required(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/categories', ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    // ===== UPDATE =====

    public function test_admin_can_update_category_name(): void
    {
        $cat = Category::create(['name' => 'OldName']);

        $this->actingAs($this->admin())
            ->put("/admin/categories/{$cat->id}", ['name' => 'NewName'])
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', ['id' => $cat->id, 'name' => 'NewName']);
    }

    public function test_update_allows_same_name_for_own_category(): void
    {
        $cat = Category::create(['name' => 'SameName']);

        $this->actingAs($this->admin())
            ->put("/admin/categories/{$cat->id}", ['name' => 'SameName'])
            ->assertRedirect('/admin/categories');
    }

    public function test_update_rejects_name_taken_by_other_category(): void
    {
        Category::create(['name' => 'TakenName']);
        $cat = Category::create(['name' => 'Other']);

        $this->actingAs($this->admin())
            ->put("/admin/categories/{$cat->id}", ['name' => 'TakenName'])
            ->assertSessionHasErrors('name');
    }

    // ===== SOFT-DEACTIVATE (destroy) =====

    public function test_destroy_deactivates_category_not_deletes(): void
    {
        $cat = Category::create(['name' => 'ToDeactivate', 'is_active' => true]);

        $this->actingAs($this->admin())
            ->delete("/admin/categories/{$cat->id}")
            ->assertRedirect('/admin/categories');

        // Record still exists in DB
        $this->assertDatabaseHas('categories', ['id' => $cat->id]);
        // But is_active set to false
        $this->assertDatabaseHas('categories', ['id' => $cat->id, 'is_active' => false]);
    }

    // ===== TOGGLE ACTIVE =====

    public function test_toggle_activates_inactive_category(): void
    {
        $cat = Category::create(['name' => 'Inactive', 'is_active' => false]);

        $this->actingAs($this->admin())
            ->patch("/admin/categories/{$cat->id}/toggle")
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', ['id' => $cat->id, 'is_active' => true]);
    }

    public function test_toggle_deactivates_active_category(): void
    {
        $cat = Category::create(['name' => 'Active', 'is_active' => true]);

        $this->actingAs($this->admin())
            ->patch("/admin/categories/{$cat->id}/toggle")
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', ['id' => $cat->id, 'is_active' => false]);
    }

    // ===== INDEX FILTERS =====

    public function test_index_shows_only_active_by_default(): void
    {
        Category::create(['name' => 'ActiveCat',   'is_active' => true]);
        Category::create(['name' => 'InactiveCat', 'is_active' => false]);

        $response = $this->actingAs($this->admin())
            ->get('/admin/categories');

        $response->assertStatus(200);
        $response->assertViewHas('filter', 'active');
    }

    public function test_index_filters_by_inactive(): void
    {
        Category::create(['name' => 'ActiveCat',   'is_active' => true]);
        Category::create(['name' => 'InactiveCat', 'is_active' => false]);

        $response = $this->actingAs($this->admin())
            ->get('/admin/categories?status=inactive');

        $response->assertStatus(200);
        $response->assertViewHas('filter', 'inactive');
    }

    public function test_index_passes_stats_to_view(): void
    {
        $response = $this->actingAs($this->admin())
            ->get('/admin/categories');

        $response->assertViewHas('stats');
        $stats = $response->viewData('stats');
        $this->assertArrayHasKey('total', $stats);
        $this->assertArrayHasKey('with_products', $stats);
        $this->assertArrayHasKey('empty', $stats);
        $this->assertArrayHasKey('total_products', $stats);
    }

    public function test_index_search_filters_by_name(): void
    {
        Category::create(['name' => 'Makanan', 'is_active' => true]);
        Category::create(['name' => 'Minuman', 'is_active' => true]);
        Category::create(['name' => 'Pakaian', 'is_active' => true]);

        $response = $this->actingAs($this->admin())
            ->get('/admin/categories?search=Maka&status=all');

        $response->assertStatus(200);
        $cats = $response->viewData('categories');
        $this->assertEquals(1, $cats->total());
        $this->assertEquals('Makanan', $cats->first()->name);
    }
}
