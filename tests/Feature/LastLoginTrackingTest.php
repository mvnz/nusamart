<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LastLoginTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_last_login_at_is_null_for_new_user(): void
    {
        $user = User::factory()->create();
        $this->assertNull($user->last_login_at);
    }

    public function test_last_login_at_is_cast_to_datetime(): void
    {
        $user = User::factory()->create(['last_login_at' => now()]);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->last_login_at);
    }

    public function test_last_login_at_is_in_fillable(): void
    {
        $user = new User();
        $this->assertContains('last_login_at', $user->getFillable());
    }

    public function test_login_updates_last_login_at(): void
    {
        $user = User::factory()->create(['last_login_at' => null]);

        // Simulate Login event (as AppServiceProvider listens to it)
        event(new Login('web', $user, false));

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
    }

    public function test_login_via_post_updates_last_login_at(): void
    {
        $user = User::factory()->create([
            'password'      => bcrypt('Password1!'),
            'last_login_at' => null,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'Password1!',
        ]);

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
    }

    public function test_last_login_at_updates_on_each_login(): void
    {
        $user = User::factory()->create([
            'password'      => bcrypt('Password1!'),
            'last_login_at' => now()->subDays(3),
        ]);

        $oldLogin = $user->last_login_at;

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'Password1!',
        ]);

        $user->refresh();
        $this->assertTrue($user->last_login_at->greaterThan($oldLogin));
    }

    public function test_admin_dashboard_passes_recent_logins(): void
    {
        User::factory()->count(5)->create(['last_login_at' => now()]);
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertViewHas('recentLogins');
    }

    public function test_recent_logins_ordered_by_latest_first(): void
    {
        $old   = User::factory()->create(['last_login_at' => now()->subHours(3)]);
        $newer = User::factory()->create(['last_login_at' => now()->subMinutes(5)]);
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/dashboard');
        $logins = $response->viewData('recentLogins');

        $this->assertEquals($newer->id, $logins->first()->id);
    }

    public function test_recent_logins_limited_to_ten(): void
    {
        User::factory()->count(15)->create(['last_login_at' => now()]);
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/dashboard');
        $logins = $response->viewData('recentLogins');

        $this->assertLessThanOrEqual(10, $logins->count());
    }
}
