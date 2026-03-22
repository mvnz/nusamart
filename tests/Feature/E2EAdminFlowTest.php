<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class E2EAdminFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_admin_user_management_flow(): void
    {
        // Step 1: Create admin and regular users
        $admin = User::factory()->admin()->create([
            'password' => 'AdminPass1!',
        ]);
        $buyer1 = User::factory()->create(['role' => 'pembeli', 'name' => 'Buyer One']);
        $buyer2 = User::factory()->create(['role' => 'pembeli', 'name' => 'Buyer Two']);
        $seller = User::factory()->penjual()->create(['name' => 'Seller One']);

        // Step 2: Admin logs in
        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'AdminPass1!',
        ]);
        $this->assertAuthenticated();

        // Step 3: Admin views dashboard with stats
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewHas('totalUsers');
        $response->assertViewHas('totalBuyers');
        $response->assertViewHas('totalSellers');
        $response->assertViewHas('totalAdmins');

        // Step 4: Admin visits user management
        $this->get('/admin/users')->assertStatus(200);

        // Step 5: Admin deactivates a user
        $this->patch("/admin/users/{$buyer1->id}/toggle")
            ->assertRedirect(route('admin.users'));
        $this->assertDatabaseHas('users', ['id' => $buyer1->id, 'is_active' => false]);

        // Step 6: Admin reactivates the user
        $this->patch("/admin/users/{$buyer1->id}/toggle")
            ->assertRedirect(route('admin.users'));
        $this->assertDatabaseHas('users', ['id' => $buyer1->id, 'is_active' => true]);

        // Step 7: Admin tries to deactivate self - should fail
        $this->patch("/admin/users/{$admin->id}/toggle")
            ->assertRedirect(route('admin.users'))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id, 'is_active' => true]);

        // Step 7: Admin logs out
        $this->post('/logout');
        $this->assertGuest();

        // Step 8: Regular user cannot access admin panel
        $this->actingAs($buyer2);
        $this->get('/admin/users')->assertStatus(403);
    }

    public function test_non_admin_full_restriction_flow(): void
    {
        // Step 1: Create a regular user
        $user = User::factory()->create([
            'role' => 'pembeli',
            'password' => 'UserPass1!',
        ]);

        // Step 2: Login
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'UserPass1!',
        ]);
        $this->assertAuthenticated();

        // Step 3: Can access dashboard
        $this->get('/dashboard')->assertStatus(200);

        // Step 4: Can access profile
        $this->get('/profile')->assertStatus(200);

        // Step 5: Cannot access admin user management
        $this->get('/admin/users')->assertStatus(403);

        // Step 6: Can access public pages
        $this->get('/tentang')->assertStatus(200);
        $this->get('/kontak')->assertStatus(200);
        $this->get('/bantuan')->assertStatus(200);
    }
}
