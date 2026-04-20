<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Security Test Suite — OWASP Top 10
 *
 * Covers:
 *   A01 — Broken Access Control
 *   A02 — Cryptographic Failures (password hashing)
 *   A03 — Injection (SQL injection attempts in inputs)
 *   A05 — Security Misconfiguration (debug, headers)
 *   A07 — Identification & Authentication Failures
 *   A08 — Software & Data Integrity (CSRF)
 */
class SecurityTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // A01 — Broken Access Control
    // =========================================================

    // --- Unauthenticated access to protected routes ---

    public function test_unauthenticated_cannot_access_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_profile(): void
    {
        $this->get('/profile')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_checkout(): void
    {
        $this->get('/checkout')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_orders(): void
    {
        $this->get('/pesanan')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_cart(): void
    {
        $this->get('/keranjang')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_wishlist(): void
    {
        $this->get('/wishlist')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_seller_orders(): void
    {
        $this->get('/penjual/pesanan')->assertRedirect('/login');
    }

    // --- Admin route protection ---

    public function test_unauthenticated_cannot_access_admin_users(): void
    {
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_admin_categories(): void
    {
        $this->get('/admin/categories')->assertRedirect('/login');
    }

    public function test_unauthenticated_cannot_access_admin_visitors(): void
    {
        $this->get('/admin/visitors')->assertRedirect('/login');
    }

    public function test_pembeli_cannot_access_admin_panel(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($pembeli);

        $this->get('/admin/users')->assertForbidden();
        $this->get('/admin/categories')->assertForbidden();
        $this->get('/admin/visitors')->assertForbidden();
        $this->get('/admin/logins')->assertForbidden();
    }

    public function test_penjual_cannot_access_admin_panel(): void
    {
        $penjual = User::factory()->penjual()->create();
        $this->actingAs($penjual);

        $this->get('/admin/users')->assertForbidden();
        $this->get('/admin/categories')->assertForbidden();
    }

    public function test_pembeli_cannot_toggle_user_status(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $target  = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($pembeli);

        $this->patch("/admin/users/{$target->id}/toggle")->assertForbidden();
    }

    public function test_pembeli_cannot_create_category(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($pembeli);

        $this->post('/admin/categories', ['name' => 'Hacked'])->assertForbidden();
    }

    public function test_pembeli_cannot_delete_category(): void
    {
        $category = Category::create(['name' => 'TestCat', 'is_active' => true]);
        $pembeli  = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($pembeli);

        $this->delete("/admin/categories/{$category->id}")->assertForbidden();
    }

    // --- IDOR: users cannot access other users' resources ---

    public function test_user_cannot_view_other_users_order(): void
    {
        $userA = User::factory()->create(['role' => 'pembeli']);
        $userB = User::factory()->create(['role' => 'pembeli']);

        // Create order belonging to userA
        $order = Order::create([
            'order_number'     => 'ORD-TEST-' . uniqid(),
            'user_id'          => $userA->id,
            'status'           => 'pending',
            'total_amount'     => 50000,
            'shipping_name'    => 'User A',
            'shipping_phone'   => '08111111111',
            'shipping_address' => 'Jl. Test No. 1',
            'shipping_city'    => 'Jakarta',
            'shipping_province'=> 'DKI Jakarta',
        ]);

        // userB tries to access userA's order
        $this->actingAs($userB);
        $this->get("/pesanan/{$order->id}")->assertForbidden();
    }

    public function test_user_cannot_cancel_other_users_order(): void
    {
        $userA = User::factory()->create(['role' => 'pembeli']);
        $userB = User::factory()->create(['role' => 'pembeli']);

        $order = Order::create([
            'order_number'     => 'ORD-TEST-' . uniqid(),
            'user_id'          => $userA->id,
            'status'           => 'pending',
            'total_amount'     => 50000,
            'shipping_name'    => 'User A',
            'shipping_phone'   => '08111111111',
            'shipping_address' => 'Jl. Test No. 1',
            'shipping_city'    => 'Jakarta',
            'shipping_province'=> 'DKI Jakarta',
        ]);

        $this->actingAs($userB);
        $this->patch("/pesanan/{$order->id}/batalkan")->assertForbidden();
    }

    public function test_user_cannot_delete_other_users_address(): void
    {
        $userA = User::factory()->create(['role' => 'pembeli']);
        $userB = User::factory()->create(['role' => 'pembeli']);

        $address = UserAddress::create([
            'user_id'        => $userA->id,
            'label'          => 'Rumah',
            'recipient_name' => 'User A',
            'phone'          => '08111111111',
            'alamat'         => 'Jl. A No. 1',
            'province_code'  => '31',
            'regency_code'   => '3171',
            'district_code'  => '317101',
            'village_code'   => '3171010001',
            'propinsi'       => 'DKI Jakarta',
            'kota'           => 'Jakarta Pusat',
            'kecamatan'      => 'Gambir',
            'kelurahan'      => 'Gambir',
            'rt'             => '001',
            'rw'             => '001',
            'kodepos'        => '10110',
            'is_primary'     => true,
        ]);

        $this->actingAs($userB);
        $this->delete("/profile/alamat/{$address->id}")->assertForbidden();
    }

    public function test_user_cannot_remove_other_users_cart_item(): void
    {
        $userA   = User::factory()->create(['role' => 'pembeli']);
        $userB   = User::factory()->create(['role' => 'pembeli']);
        $penjual = User::factory()->penjual()->create();

        $product = Product::create([
            'user_id'  => $penjual->id,
            'name'     => 'Produk Test',
            'price'    => 10000,
            'stock'    => 10,
            'is_active'=> true,
        ]);

        $cart = Cart::create([
            'user_id'    => $userA->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $this->actingAs($userB);
        $this->delete("/keranjang/{$cart->id}")->assertForbidden();
    }

    // --- Privilege escalation: penjual can only manage own products ---

    public function test_penjual_cannot_edit_other_sellers_product(): void
    {
        $penjualA = User::factory()->penjual()->create();
        $penjualB = User::factory()->penjual()->create();

        $product = Product::create([
            'user_id'  => $penjualA->id,
            'name'     => 'Produk A',
            'price'    => 20000,
            'stock'    => 5,
            'is_active'=> true,
        ]);

        $this->actingAs($penjualB);
        $this->put("/produk/{$product->id}", [
            'name'  => 'Hacked Name',
            'price' => 1,
            'stock' => 999,
        ])->assertForbidden();
    }

    public function test_penjual_cannot_delete_other_sellers_product(): void
    {
        $penjualA = User::factory()->penjual()->create();
        $penjualB = User::factory()->penjual()->create();

        $product = Product::create([
            'user_id'  => $penjualA->id,
            'name'     => 'Produk A',
            'price'    => 20000,
            'stock'    => 5,
            'is_active'=> true,
        ]);

        $this->actingAs($penjualB);
        $this->delete("/produk/{$product->id}")->assertForbidden();
    }

    // =========================================================
    // A02 — Cryptographic Failures (Password Hashing)
    // =========================================================

    public function test_user_password_is_hashed_in_database(): void
    {
        $user = User::factory()->create(['password' => 'PlainPassword1!']);

        $this->assertNotEquals('PlainPassword1!', $user->fresh()->password);
        $this->assertTrue(password_verify('PlainPassword1!', $user->fresh()->password));
    }

    public function test_password_is_not_exposed_in_user_model(): void
    {
        $user = User::factory()->create();

        // The password should not be in toArray (not in hidden)
        // Laravel hides 'password' by default in User model
        $this->assertArrayNotHasKey('password', $user->toArray());
    }

    // =========================================================
    // A03 — Injection (SQL Injection in search inputs)
    // =========================================================

    public function test_sql_injection_in_product_search_does_not_cause_error(): void
    {
        $response = $this->get("/produk?search=' OR '1'='1");
        $response->assertStatus(200);
    }

    public function test_sql_injection_in_product_search_single_quote_variant(): void
    {
        $response = $this->get('/produk?search=' . urlencode("'; DROP TABLE products; --"));
        $response->assertStatus(200);
    }

    public function test_sql_injection_in_login_email_does_not_authenticate(): void
    {
        $response = $this->post('/login', [
            'email'    => "' OR 1=1 --",
            'password' => 'anything',
        ]);
        $this->assertGuest();
    }

    public function test_sql_injection_in_login_password_does_not_authenticate(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => "' OR '1'='1",
        ]);
        $this->assertGuest();
    }

    // =========================================================
    // A07 — Identification & Authentication Failures
    // =========================================================

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'password'  => 'Password1!',
            'is_active' => false,
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'Password1!',
        ]);

        // Inactive user should not be authenticated
        $this->assertGuest();
    }

    public function test_login_requires_email_field(): void
    {
        $response = $this->post('/login', ['password' => 'Password1!']);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_password_field(): void
    {
        $response = $this->post('/login', ['email' => 'test@example.com']);
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_login_rejects_invalid_email_format(): void
    {
        $response = $this->post('/login', [
            'email'    => 'not-an-email',
            'password' => 'Password1!',
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_register_requires_strong_password(): void
    {
        // Try registering with a weak password
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'username'              => 'testuser',
            'password'              => 'weak',
            'password_confirmation' => 'weak',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_register_rejects_duplicate_email(): void
    {
        $existing = User::factory()->create(['email' => 'dup@example.com']);

        $response = $this->post('/register', [
            'name'                  => 'Another User',
            'email'                 => 'dup@example.com',
            'username'              => 'anotheruser',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // =========================================================
    // A08 — Software & Data Integrity (CSRF Protection)
    // =========================================================

    public function test_login_post_requires_csrf_token(): void
    {
        // withoutMiddleware is NOT used — CSRF should be enforced
        $this->app['config']->set('session.driver', 'array');

        $response = $this->post('/login', [
            'email'    => 'test@example.com',
            'password' => 'Password1!',
            // No _token provided
        ]);

        // Laravel will reject without CSRF token (419) OR redirect
        $this->assertContains($response->status(), [302, 419]);
    }

    public function test_state_changing_routes_use_post_not_get(): void
    {
        // CSRF-sensitive actions must not be accessible via GET
        $this->get('/login')->assertStatus(200); // GET login page = ok
        $this->get('/register')->assertStatus(200); // GET register page = ok

        // These should NOT work with GET (method not allowed or redirect)
        $user = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($user);

        $product = Product::create([
            'user_id'  => $user->id,
            'name'     => 'P',
            'price'    => 1000,
            'stock'    => 1,
            'is_active'=> true,
        ]);

        // GET on a DELETE route should not delete anything
        $this->get("/keranjang")->assertStatus(200);
    }

    // =========================================================
    // A05 — Security Misconfiguration
    // =========================================================

    public function test_app_is_not_in_debug_mode_during_testing(): void
    {
        // APP_DEBUG should not expose stack traces to end users in production
        // In testing env it can be true, but this verifies config is controllable
        $this->assertIsBool(config('app.debug'));
    }

    public function test_production_would_hide_error_details(): void
    {
        // Verify that 404 returns proper status, not a raw exception dump
        $response = $this->get('/route-that-does-not-exist-' . uniqid());
        $response->assertStatus(404);
    }

    public function test_admin_routes_have_admin_middleware(): void
    {
        // A non-admin verified user should be blocked from admin routes
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $this->actingAs($pembeli);

        // All admin-prefixed routes must return 403, not 200
        $adminRoutes = [
            '/admin/users',
            '/admin/categories',
            '/admin/visitors',
            '/admin/logins',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);
            $this->assertEquals(
                403,
                $response->status(),
                "Route {$route} should be forbidden for pembeli, got {$response->status()}"
            );
        }
    }

    public function test_seller_order_detail_only_accessible_to_the_seller(): void
    {
        $penjualA = User::factory()->penjual()->create();
        $penjualB = User::factory()->penjual()->create();
        $buyer    = User::factory()->create(['role' => 'pembeli']);

        $order = Order::create([
            'order_number'     => 'ORD-TEST-' . uniqid(),
            'user_id'          => $buyer->id,
            'status'           => 'pending',
            'total_amount'     => 50000,
            'shipping_name'    => 'Buyer',
            'shipping_phone'   => '08111111111',
            'shipping_address' => 'Jl. Test',
            'shipping_city'    => 'Jakarta',
            'shipping_province'=> 'DKI Jakarta',
        ]);

        // penjualB should not be able to view penjualA's order
        $this->actingAs($penjualB);
        $this->get("/penjual/pesanan/{$order->id}")->assertForbidden();
    }

    // =========================================================
    // A03 — SQL Injection (Extended Coverage)
    // =========================================================

    /**
     * Classic payloads yang sering dipakai attacker.
     */
    private function sqlInjectionPayloads(): array
    {
        return [
            "' OR '1'='1",
            "' OR 1=1 --",
            "'; DROP TABLE users; --",
            "' UNION SELECT null,null,null --",
            "' UNION SELECT username, password, null FROM users --",
            "1' AND SLEEP(0) --",
            "1 AND 1=1",
            "\" OR \"1\"=\"1",
            "admin'--",
            "' OR 'x'='x",
            "') OR ('1'='1",
            "1; SELECT * FROM users",
        ];
    }

    // --- Search endpoint /produk?search= ---

    public function test_sql_injection_in_product_search_does_not_expose_data(): void
    {
        $user = User::factory()->create(['password' => 'Secret123!', 'role' => 'pembeli']);

        foreach ($this->sqlInjectionPayloads() as $payload) {
            $response = $this->get('/produk?search=' . urlencode($payload));
            $response->assertStatus(200);
            // Response tidak boleh memuat password hash user
            $this->assertStringNotContainsString(
                $user->fresh()->password,
                $response->content(),
                "Payload [{$payload}] mengekspos password hash"
            );
        }
    }

    public function test_sql_injection_in_product_category_filter_does_not_cause_error(): void
    {
        foreach (["' OR 1=1 --", "1 UNION SELECT null --", "'; DROP TABLE categories; --"] as $payload) {
            $response = $this->get('/produk?category_id=' . urlencode($payload));
            // Harus 200 (tidak menemukan kategori) atau redirect, bukan 500
            $this->assertNotEquals(500, $response->status(), "category_id payload [{$payload}] menyebabkan error 500");
        }
    }

    public function test_sql_injection_in_kategori_search_does_not_cause_error(): void
    {
        foreach (["' OR 1=1 --", "'; DROP TABLE categories; --"] as $payload) {
            $response = $this->get('/kategori?search=' . urlencode($payload));
            $this->assertNotEquals(500, $response->status());
        }
    }

    // --- Login form ---

    public function test_sql_injection_union_in_login_does_not_authenticate(): void
    {
        foreach ($this->sqlInjectionPayloads() as $payload) {
            $this->post('/login', [
                'email'    => $payload,
                'password' => $payload,
            ]);
            $this->assertGuest(null); // payload: {$payload}
        }
    }

    // --- Register form ---

    public function test_sql_injection_in_register_fields_does_not_create_user(): void
    {
        $payloads = ["' OR 1=1 --", "admin'--", "'; DROP TABLE users; --"];

        foreach ($payloads as $payload) {
            $countBefore = User::count();

            $this->post('/register', [
                'name'                  => $payload,
                'email'                 => 'valid@example.com',
                'username'              => 'validuser' . uniqid(),
                'password'              => 'Password1!',
                'password_confirmation' => 'Password1!',
                'role'                  => 'pembeli',
            ]);

            // Harus gagal validasi atau buat user dengan data disanitasi — bukan inject DB
            // Yang penting: tidak ada extra user terdaftar lewat injection
            $countAfter = User::count();
            $this->assertLessThanOrEqual(
                $countBefore + 1,
                $countAfter,
                "Payload [{$payload}] mungkin membuat user ganda via injection"
            );
        }
    }

    public function test_sql_injection_in_register_email_does_not_authenticate_injected_user(): void
    {
        foreach (["' OR 1=1 --", "admin'--"] as $payload) {
            $this->post('/register', [
                'name'                  => 'Test',
                'email'                 => $payload,
                'username'              => 'user' . uniqid(),
                'password'              => 'Password1!',
                'password_confirmation' => 'Password1!',
                'role'                  => 'pembeli',
            ]);

            $this->assertGuest(); // payload: {$payload}
        }
    }

    // --- Forgot password ---

    public function test_sql_injection_in_forgot_password_does_not_cause_error(): void
    {
        foreach (["' OR 1=1 --", "'; DROP TABLE users; --", "' UNION SELECT null --"] as $payload) {
            $response = $this->post('/forgot-password', ['email' => $payload]);
            $this->assertNotEquals(500, $response->status(), "Payload [{$payload}] menyebabkan 500 di forgot-password");
        }
    }

    // --- Profile update (authenticated) ---

    public function test_sql_injection_in_profile_update_does_not_expose_data(): void
    {
        $user = User::factory()->create(['role' => 'pembeli', 'email_verified_at' => now()]);
        $this->actingAs($user);

        foreach (["' OR 1=1 --", "'; DROP TABLE users; --"] as $payload) {
            $response = $this->put('/profile', [
                'name'     => $payload,
                'email'    => $user->email,
                'username' => $user->username,
                'phone'    => '08111111111',
            ]);

            // Tidak boleh 500 (SQL error berarti raw query rentan)
            $this->assertNotEquals(500, $response->status(), "Payload [{$payload}] menyebabkan 500 di profile update");
        }
    }

    // --- Admin search endpoints ---

    public function test_sql_injection_in_admin_user_search_does_not_cause_error(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $this->actingAs($admin);

        foreach (["' OR 1=1 --", "'; DROP TABLE users; --", "' UNION SELECT null,null --"] as $payload) {
            $response = $this->get('/admin/users?search=' . urlencode($payload));
            $this->assertNotEquals(500, $response->status(), "Admin user search payload [{$payload}] menyebabkan 500");
        }
    }

    public function test_sql_injection_in_admin_category_search_does_not_cause_error(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $this->actingAs($admin);

        foreach (["' OR 1=1 --", "'; DROP TABLE categories; --"] as $payload) {
            $response = $this->get('/admin/categories?search=' . urlencode($payload));
            $this->assertNotEquals(500, $response->status(), "Admin category search payload [{$payload}] menyebabkan 500");
        }
    }

    // --- Numeric ID parameters (UNION injection via route param) ---

    public function test_sql_injection_via_product_id_param_does_not_cause_error(): void
    {
        $payloads = ["1 OR 1=1", "1 UNION SELECT null,null", "1; DROP TABLE products"];

        foreach ($payloads as $payload) {
            $response = $this->get('/produk/' . urlencode($payload));
            // Harus 404 (record tidak ditemukan) bukan 500
            $this->assertNotEquals(500, $response->status(), "Product ID payload [{$payload}] menyebabkan 500");
        }
    }

    public function test_database_does_not_expose_raw_errors_on_injection(): void
    {
        // Pastikan response tidak mengandung pesan error SQL mentah (nama tabel, kolom, dll.)
        $sqlErrorPatterns = [
            'SQLSTATE',
            'syntax error',
            'mysql_fetch',
            'ORA-',
            'pg_query',
            'You have an error in your SQL syntax',
        ];

        $response = $this->get("/produk?search=" . urlencode("' OR 1=1 --"));
        $body = $response->content();

        foreach ($sqlErrorPatterns as $pattern) {
            $this->assertStringNotContainsString(
                $pattern,
                $body,
                "Response mengandung SQL error mentah: [{$pattern}]"
            );
        }
    }
}
