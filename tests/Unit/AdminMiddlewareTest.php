<?php

namespace Tests\Unit;

use App\Http\Middleware\AdminMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_pass_middleware(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $request = Request::create('/admin/users', 'GET');
        $middleware = new AdminMiddleware();

        $response = $middleware->handle($request, function () {
            return new Response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_non_admin_is_rejected(): void
    {
        $user = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($user);

        $request = Request::create('/admin/users', 'GET');
        $middleware = new AdminMiddleware();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $middleware->handle($request, function () {
            return new Response('OK');
        });
    }

    public function test_guest_is_rejected(): void
    {
        $request = Request::create('/admin/users', 'GET');
        $middleware = new AdminMiddleware();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $middleware->handle($request, function () {
            return new Response('OK');
        });
    }
}
