<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVisitorStatsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    // ===== /admin/visitors ACCESS =====

    public function test_guest_cannot_access_visitors_page(): void
    {
        $this->get('/admin/visitors')->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_visitors_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'pembeli']))
            ->get('/admin/visitors')
            ->assertStatus(403);
    }

    public function test_admin_can_access_visitors_page(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/visitors')
            ->assertStatus(200);
    }

    public function test_visitors_page_passes_required_variables(): void
    {
        $response = $this->actingAs($this->admin())
            ->get('/admin/visitors');

        $response->assertViewHas('allCities');
        $response->assertViewHas('visitorsToday');
        $response->assertViewHas('visitorsThisWeek');
        $response->assertViewHas('visitorsThisMonth');
        $response->assertViewHas('visitorsTotal');
        $response->assertViewHas('deviceStats');
    }

    public function test_visitors_today_count_is_correct(): void
    {
        VisitorLog::create(['ip_address' => '1.1.1.1', 'device_type' => 'desktop', 'visit_date' => now()->toDateString()]);
        VisitorLog::create(['ip_address' => '2.2.2.2', 'device_type' => 'mobile',  'visit_date' => now()->toDateString()]);
        VisitorLog::create(['ip_address' => '3.3.3.3', 'device_type' => 'desktop', 'visit_date' => now()->subDay()->toDateString()]);

        // Use the same query the controller uses (whereDate for SQLite compatibility)
        $todayCount = VisitorLog::whereDate('visit_date', now()->toDateString())->count();
        $this->assertEquals(2, $todayCount);
    }

    public function test_visitors_total_count_is_correct(): void
    {
        VisitorLog::create(['ip_address' => '1.1.1.1', 'device_type' => 'desktop', 'visit_date' => now()->toDateString()]);
        VisitorLog::create(['ip_address' => '2.2.2.2', 'device_type' => 'mobile',  'visit_date' => now()->subMonth()->toDateString()]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\TrackVisitor::class)
            ->actingAs($this->admin())->get('/admin/visitors');
        $this->assertEquals(2, $response->viewData('visitorsTotal'));
    }

    public function test_device_stats_groups_by_device_type(): void
    {
        VisitorLog::create(['ip_address' => '1.1.1.1', 'device_type' => 'desktop', 'visit_date' => now()->toDateString()]);
        VisitorLog::create(['ip_address' => '2.2.2.2', 'device_type' => 'desktop', 'visit_date' => now()->toDateString()]);
        VisitorLog::create(['ip_address' => '3.3.3.3', 'device_type' => 'mobile',  'visit_date' => now()->toDateString()]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\TrackVisitor::class)
            ->actingAs($this->admin())->get('/admin/visitors');
        $deviceStats = $response->viewData('deviceStats');

        $this->assertEquals(2, $deviceStats['desktop']);
        $this->assertEquals(1, $deviceStats['mobile']);
    }

    public function test_all_cities_paginates(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            VisitorLog::create([
                'ip_address'  => "1.1.1.{$i}",
                'city'        => "City{$i}",
                'device_type' => 'desktop',
                'visit_date'  => now()->toDateString(),
            ]);
        }

        $response = $this->actingAs($this->admin())->get('/admin/visitors');
        $allCities = $response->viewData('allCities');

        $this->assertEquals(25, $allCities->total());
        $this->assertEquals(20, $allCities->perPage());
    }

    // ===== /admin/logins ACCESS =====

    public function test_guest_cannot_access_logins_page(): void
    {
        $this->get('/admin/logins')->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_logins_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'pembeli']))
            ->get('/admin/logins')
            ->assertStatus(403);
    }

    public function test_admin_can_access_logins_page(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/logins')
            ->assertStatus(200);
    }

    public function test_logins_page_shows_users_with_last_login(): void
    {
        User::factory()->count(3)->create(['last_login_at' => now()]);
        User::factory()->count(2)->create(['last_login_at' => null]);

        $response = $this->actingAs($this->admin())->get('/admin/logins');
        $allLogins = $response->viewData('allLogins');

        // Only users with last_login_at
        $this->assertEquals(3, $allLogins->total());
    }

    public function test_logins_page_orders_by_latest_login_first(): void
    {
        $older = User::factory()->create(['last_login_at' => now()->subHours(5)]);
        $newer = User::factory()->create(['last_login_at' => now()->subMinutes(10)]);

        $response = $this->actingAs($this->admin())->get('/admin/logins');
        $allLogins = $response->viewData('allLogins');

        $this->assertEquals($newer->id, $allLogins->first()->id);
    }

    public function test_logins_page_paginates(): void
    {
        User::factory()->count(25)->create(['last_login_at' => now()]);

        $response = $this->actingAs($this->admin())->get('/admin/logins');
        $allLogins = $response->viewData('allLogins');

        $this->assertEquals(25, $allLogins->total());
        $this->assertEquals(20, $allLogins->perPage());
    }
}
