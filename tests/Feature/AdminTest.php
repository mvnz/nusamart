<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    // ===== DASHBOARD =====

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_dashboard_requires_verified_email(): void
    {
        $user = User::factory()->unverified()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_shows_statistics(): void
    {
        User::factory()->count(3)->create(['role' => 'pembeli']);
        User::factory()->count(2)->penjual()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewHas('totalUsers');
        $response->assertViewHas('totalSellers');
        $response->assertViewHas('totalBuyers');
        $response->assertViewHas('totalAdmins');
        $response->assertViewHas('recentUsers');
    }

    // ===== USER MANAGEMENT =====

    public function test_admin_can_access_user_management(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $response = $this->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_user_management(): void
    {
        $user = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($user);

        $response = $this->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::factory()->admin()->create();
        $target = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->delete("/admin/users/{$target->id}");

        $response->assertRedirect(route('admin.users'));
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $response = $this->delete("/admin/users/{$admin->id}");

        $response->assertRedirect(route('admin.users'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_guest_cannot_access_admin_routes(): void
    {
        $response = $this->get('/admin/users');
        // Guest is redirected to login by auth middleware before admin middleware runs
        $response->assertRedirect('/login');
    }
}
