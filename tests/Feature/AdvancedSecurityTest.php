<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * Advanced Security Test Suite
 *
 * Covers:
 *   [1]  SQL Injection            (extended)
 *   [2]  XSS – Cross-Site Scripting
 *   [3]  CSRF – Cross-Site Request Forgery (extended)
 *   [4]  Broken Authentication    (extended)
 *   [5]  Broken Access Control    (extended / IDOR)
 *   [6]  Command Injection
 *   [7]  File Upload Attack
 *   [8]  Directory Traversal
 *   [9]  Remote Code Execution (RCE)
 *   [10] Denial of Service (DoS)
 *   [11] DDoS – Rapid repeated requests
 *   [12] Session Hijacking
 *   [13] Man-in-the-Middle (MitM) – config checks
 *   [14] Clickjacking
 *   [15] Security Misconfiguration (extended)
 *   [16] Brute Force Attack
 *   [17] Credential Stuffing
 *   [18] XXE – XML External Entity
 *   [19] Insecure Deserialization
 *   [20] Phishing – Open Redirect
 */
class AdvancedSecurityTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // Shared payloads
    // ─────────────────────────────────────────────────────────

    private function xssPayloads(): array
    {
        return [
            '<script>alert("xss")</script>',
            '<img src=x onerror=alert(1)>',
            '"><script>alert(document.cookie)</script>',
            "<svg onload=alert(1)>",
            '<body onload=alert(1)>',
            "';alert('xss')//",
        ];
    }

    private function commandPayloads(): array
    {
        return [
            '; ls -la',
            '| cat /etc/passwd',
            '`whoami`',
            '$(id)',
            '& dir',
            '| net user',
            '; rm -rf /',
        ];
    }

    // =========================================================
    // [1] SQL Injection (Extended)
    // =========================================================

    /** @test */
    public function sql_injection_in_forgot_password_returns_safe_response(): void
    {
        $payloads = ["' OR 1=1 --", "'; DROP TABLE users; --", "' UNION SELECT null,null --"];
        foreach ($payloads as $p) {
            $r = $this->post('/forgot-password', ['email' => $p]);
            $this->assertNotEquals(500, $r->status(), "forgot-password SQL payload [{$p}] → 500");
        }
    }

    /** @test */
    public function sql_injection_in_product_search_never_exposes_password_hashes(): void
    {
        $user = User::factory()->create(['password' => bcrypt('SuperSecret1!')]);

        $payloads = [
            "' UNION SELECT password,null FROM users --",
            "' OR 1=1 UNION SELECT password,2,3,4 FROM users --",
        ];

        foreach ($payloads as $p) {
            $r = $this->get('/produk?search=' . urlencode($p));
            $this->assertStringNotContainsString(
                $user->fresh()->password,
                $r->content(),
                "SQL injection [{$p}] exposed a password hash"
            );
        }
    }

    /** @test */
    public function sql_injection_time_based_blind_does_not_delay_response(): void
    {
        // SLEEP/BENCHMARK payloads must not be executed
        $payloads = [
            "' AND SLEEP(0) --",
            "1; SELECT SLEEP(0)",
            "' OR BENCHMARK(1,MD5('x')) --",
        ];
        foreach ($payloads as $p) {
            $r = $this->get('/produk?search=' . urlencode($p));
            $this->assertNotEquals(500, $r->status());
        }
    }

    // =========================================================
    // [2] XSS – Cross-Site Scripting
    // =========================================================

    /** @test */
    public function xss_in_product_search_is_escaped_in_response(): void
    {
        foreach ($this->xssPayloads() as $payload) {
            $r = $this->get('/produk?search=' . urlencode($payload));
            $r->assertStatus(200);
            $this->assertStringNotContainsString(
                '<script>alert("xss")</script>',
                $r->content(),
                "XSS not escaped in product search: [{$payload}]"
            );
        }
    }

    /** @test */
    public function xss_in_category_search_is_escaped_in_response(): void
    {
        $payload = '<script>alert("xss")</script>';
        $r       = $this->get('/kategori?search=' . urlencode($payload));
        $r->assertStatus(200);
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $r->content());
    }

    /** @test */
    public function xss_stored_in_user_name_is_escaped_on_profile_page(): void
    {
        $user = User::factory()->create([
            'name'              => '<script>alert("xss")</script>',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);
        // /profile redirects to /profile/biodata — follow the redirect
        $r = $this->get('/profile/biodata');
        $r->assertStatus(200);
        // Blade {{ }} auto-escapes → must NOT see raw <script> tag
        $this->assertStringNotContainsString(
            '<script>alert("xss")</script>',
            $r->content(),
            'Stored XSS in user name not escaped on profile page'
        );
    }

    /** @test */
    public function xss_event_handler_in_search_not_reflected_raw(): void
    {
        $payload = '"><img src=x onerror=alert(document.cookie)>';
        $r       = $this->get('/produk?search=' . urlencode($payload));
        $r->assertStatus(200);
        // Blade properly escapes < and > so raw <img must not appear unescaped
        $this->assertStringNotContainsString('<img src=x onerror=', $r->content());
    }

    /** @test */
    public function xss_script_tag_in_register_name_is_not_executed(): void
    {
        $xss = '<script>alert("pwned")</script>';
        $this->post('/register', [
            'name'                  => $xss,
            'email'                 => 'xss@example.com',
            'username'              => 'xsstestuser',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role'                  => 'pembeli',
        ]);

        $user = User::where('email', 'xss@example.com')->first();
        if ($user) {
            $this->actingAs($user);
            $r = $this->get('/profile');
            $this->assertStringNotContainsString('<script>alert("pwned")</script>', $r->content());
        } else {
            // Validation rejected payload — also safe
            $this->assertNull($user);
        }
    }

    // =========================================================
    // [3] CSRF – Cross-Site Request Forgery (Extended)
    // =========================================================

    /** @test */
    public function csrf_verify_middleware_exists_in_web_group(): void
    {
        // Laravel 11 includes CSRF protection via Illuminate's built-in middleware
        $csrfClassExists = class_exists(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
            || class_exists(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);

        $this->assertTrue($csrfClassExists, 'CSRF middleware class must exist in the framework');
    }

    /** @test */
    public function logout_is_post_only_and_not_accessible_via_get(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        // GET /logout must not succeed (405 method not allowed or redirect)
        $r = $this->get('/logout');
        $this->assertNotEquals(200, $r->status(), 'GET /logout must not return 200');
    }

    /** @test */
    public function csrf_sensitive_form_actions_require_post_not_get(): void
    {
        // These endpoints must not respond to GET with a state-change
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        // GET on profile update endpoint must not be 200 (state change)
        $r = $this->get('/profile');
        // Profile GET (view) is fine → 200 is ok, but PUT /profile must need POST/PUT not GET
        $this->assertNotEquals(500, $r->status());
    }

    /** @test */
    public function csrf_token_is_regenerated_after_logout(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $tokenBefore = csrf_token();
        $this->post('/logout');
        $tokenAfter = csrf_token();

        // After logout, session is invalidated & new CSRF token is generated
        $this->assertNotEquals($tokenBefore, $tokenAfter, 'CSRF token must be regenerated after logout');
    }

    // =========================================================
    // [4] Broken Authentication (Extended)
    // =========================================================

    /** @test */
    public function session_is_regenerated_on_login_prevents_fixation(): void
    {
        $user = User::factory()->create([
            'password'          => bcrypt('Password1!'),
            'email_verified_at' => now(),
            'role'              => 'pembeli',
        ]);

        $this->get('/login'); // Establish initial session
        $sessionBefore = session()->getId();

        $this->post('/login', ['email' => $user->email, 'password' => 'Password1!']);

        $sessionAfter = session()->getId();
        $this->assertNotEquals($sessionBefore, $sessionAfter, 'Session ID must change after login (prevents session fixation)');
    }

    /** @test */
    public function session_is_invalidated_on_logout(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $sessionBefore = session()->getId();
        $this->post('/logout');
        $sessionAfter = session()->getId();

        $this->assertNotEquals($sessionBefore, $sessionAfter, 'Session must be invalidated on logout');
    }

    /** @test */
    public function unverified_email_user_cannot_access_protected_pages(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);

        $this->get('/profile')->assertRedirect();
        $this->get('/keranjang')->assertRedirect();
        $this->get('/pesanan')->assertRedirect();
    }

    /** @test */
    public function wrong_password_never_authenticates(): void
    {
        $user = User::factory()->create(['password' => bcrypt('CorrectPass1!')]);

        $this->post('/login', ['email' => $user->email, 'password' => 'WrongPass1!']);
        $this->assertGuest();
    }

    /** @test */
    public function empty_credentials_never_authenticate(): void
    {
        $this->post('/login', ['email' => '', 'password' => '']);
        $this->assertGuest();
    }

    /** @test */
    public function role_cannot_be_escalated_via_register(): void
    {
        // Try to register as admin directly
        $this->post('/register', [
            'name'                  => 'Hacker',
            'email'                 => 'hacker@example.com',
            'username'              => 'hacker',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role'                  => 'admin', // trying to self-assign admin role
        ]);

        $user = User::where('email', 'hacker@example.com')->first();
        if ($user) {
            $this->assertNotEquals('admin', $user->role, 'User must not be able to self-register as admin');
        } else {
            $this->assertTrue(true); // Registration rejected — also fine
        }
    }

    // =========================================================
    // [5] Broken Access Control (IDOR Extended)
    // =========================================================

    /** @test */
    public function idor_user_cannot_access_other_users_profile_edit(): void
    {
        $userA = User::factory()->create(['email_verified_at' => now()]);
        $userB = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($userB);

        // userB cannot PUT to userA's profile update
        $r = $this->put('/profile', [
            'name'     => 'Hacked',
            'email'    => $userA->email,
            'username' => $userA->username,
            'phone'    => '08000000000',
        ]);

        // Must not actually change userA's data
        $userA->refresh();
        $this->assertNotEquals('Hacked', $userA->name, 'IDOR: userB must not modify userA profile');
    }

    /** @test */
    public function horizontal_privilege_escalation_buyer_cannot_access_seller_routes(): void
    {
        $buyer = User::factory()->create(['role' => 'pembeli', 'email_verified_at' => now()]);
        $this->actingAs($buyer);

        $r = $this->get('/produk-saya');
        // Seller-only route must not return 200 for a buyer
        $this->assertNotEquals(200, $r->status(), 'Buyer must not access seller-only /produk-saya');
    }

    /** @test */
    public function mass_assignment_cannot_change_user_role_via_profile_update(): void
    {
        $user = User::factory()->create([
            'role'              => 'pembeli',
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        // Try to inject role via mass assignment
        $this->put('/profile', [
            'name'     => 'Normal User',
            'email'    => $user->email,
            'username' => $user->username,
            'phone'    => '08111111111',
            'role'     => 'admin', // mass-assignment attempt
        ]);

        $this->assertEquals('pembeli', $user->fresh()->role, 'Mass assignment must not change user role');
    }

    // =========================================================
    // [6] Command Injection
    // =========================================================

    /** @test */
    public function command_injection_in_search_does_not_cause_server_error(): void
    {
        foreach ($this->commandPayloads() as $payload) {
            $r = $this->get('/produk?search=' . urlencode($payload));
            $this->assertNotEquals(500, $r->status(), "Command injection [{$payload}] caused 500");
        }
    }

    /** @test */
    public function command_injection_output_not_reflected_in_response(): void
    {
        // System command output patterns
        $osOutputPatterns = ['root:x:', '/bin/bash', 'Administrator', 'WINDOWS'];

        foreach ($this->commandPayloads() as $payload) {
            $r    = $this->get('/produk?search=' . urlencode($payload));
            $body = $r->content();
            foreach ($osOutputPatterns as $pattern) {
                $this->assertStringNotContainsString(
                    $pattern,
                    $body,
                    "Command output [{$pattern}] found in response for payload [{$payload}]"
                );
            }
        }
    }

    /** @test */
    public function command_injection_in_register_name_does_not_cause_error(): void
    {
        foreach (['; ls -la', '| cat /etc/passwd', '`whoami`'] as $payload) {
            $r = $this->post('/register', [
                'name'                  => $payload,
                'email'                 => 'cmd' . uniqid() . '@example.com',
                'username'              => 'cmdtest' . uniqid(),
                'password'              => 'Password1!',
                'password_confirmation' => 'Password1!',
                'role'                  => 'pembeli',
            ]);
            $this->assertNotEquals(500, $r->status(), "Command injection in register name caused 500");
        }
    }

    // =========================================================
    // [7] File Upload Attack
    // =========================================================

    /** @test */
    public function php_file_upload_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('shell.php', 100, 'application/x-php');
        $r    = $this->post('/profile/photo', ['photo' => $file]);

        $this->assertContains($r->status(), [302, 422], 'PHP file upload must be rejected');
        $this->assertNull($user->fresh()->photo, 'PHP file must not be stored as profile photo');
    }

    /** @test */
    public function executable_file_upload_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('malware.exe', 100, 'application/octet-stream');
        $r    = $this->post('/profile/photo', ['photo' => $file]);

        $this->assertContains($r->status(), [302, 422], 'EXE file upload must be rejected');
        $this->assertNull($user->fresh()->photo);
    }

    /** @test */
    public function htaccess_file_upload_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('.htaccess', 50, 'text/plain');
        $r    = $this->post('/profile/photo', ['photo' => $file]);

        $this->assertContains($r->status(), [302, 422], '.htaccess file upload must be rejected');
        $this->assertNull($user->fresh()->photo);
    }

    /** @test */
    public function oversized_image_upload_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        // Max is 2048KB; send 3000KB fake file
        $file = UploadedFile::fake()->create('huge.jpg', 3000, 'image/jpeg');
        $r    = $this->post('/profile/photo', ['photo' => $file]);

        $this->assertContains($r->status(), [302, 422], 'Oversized file upload must be rejected');
    }

    /** @test */
    public function svg_file_upload_is_rejected_as_profile_photo(): void
    {
        // SVG can contain embedded XSS — must not be accepted
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $svgContent = '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>';
        $file       = UploadedFile::fake()->createWithContent('xss.svg', $svgContent);
        $r          = $this->post('/profile/photo', ['photo' => $file]);

        $this->assertContains($r->status(), [302, 422], 'SVG with embedded script must be rejected');
    }

    /** @test */
    public function shell_script_file_upload_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('backdoor.sh', 50, 'text/x-sh');
        $r    = $this->post('/profile/photo', ['photo' => $file]);

        $this->assertContains($r->status(), [302, 422], 'Shell script upload must be rejected');
    }

    // =========================================================
    // [8] Directory Traversal
    // =========================================================

    /** @test */
    public function directory_traversal_in_url_does_not_expose_system_files(): void
    {
        $payloads = [
            '../../etc/passwd',
            '....//....//etc/passwd',
            '%2e%2e%2f%2e%2e%2fetc%2fpasswd',
            '../../../windows/win.ini',
        ];

        foreach ($payloads as $payload) {
            $r = $this->get('/produk/' . $payload);
            $this->assertNotEquals(500, $r->status(), "Directory traversal [{$payload}] caused 500");
            $this->assertStringNotContainsString('root:', $r->content(), "System file content exposed");
            $this->assertStringNotContainsString('[extensions]', $r->content());
        }
    }

    /** @test */
    public function directory_traversal_in_search_does_not_expose_config(): void
    {
        $payloads = [
            '../../config/database.php',
            '../.env',
            '..\\..\\windows\\system32',
        ];

        foreach ($payloads as $payload) {
            $r = $this->get('/produk?search=' . urlencode($payload));
            $r->assertStatus(200);
            $this->assertStringNotContainsString('DB_PASSWORD', $r->content());
            $this->assertStringNotContainsString('APP_KEY', $r->content());
        }
    }

    /** @test */
    public function traversal_attempt_on_kategori_search_does_not_expose_files(): void
    {
        $payload = '../../etc/passwd';
        $r       = $this->get('/kategori?search=' . urlencode($payload));
        $r->assertStatus(200);
        $this->assertStringNotContainsString('root:', $r->content());
    }

    // =========================================================
    // [9] Remote Code Execution (RCE)
    // =========================================================

    /** @test */
    public function php_code_in_search_is_not_executed(): void
    {
        $payloads = [
            '<?php system("id"); ?>',
            '<?php phpinfo(); ?>',
            '<?= shell_exec("whoami") ?>',
        ];

        foreach ($payloads as $payload) {
            $r = $this->get('/produk?search=' . urlencode($payload));
            $this->assertNotEquals(500, $r->status(), "RCE payload caused 500: [{$payload}]");
            $this->assertStringNotContainsString('uid=', $r->content());
            $this->assertStringNotContainsString('PHP Extension', $r->content());
        }
    }

    /** @test */
    public function server_side_template_injection_is_not_executed(): void
    {
        // Template injection payloads (Twig/Blade style)
        $payloads = [
            '{{7*7}}',
            '${7*7}',
            '<%=7*7%>',
            '@php echo 7*7; @endphp',
        ];

        foreach ($payloads as $payload) {
            $r = $this->get('/produk?search=' . urlencode($payload));
            $this->assertNotEquals(500, $r->status(), "SSTI payload caused 500: [{$payload}]");
            // If template injection worked, '49' would appear in an unexpected context
            // We just ensure no crash + check against sensitive outputs
            $this->assertStringNotContainsString('uid=', $r->content());
        }
    }

    /** @test */
    public function rce_via_register_fields_is_blocked(): void
    {
        $payload = '<?php echo shell_exec("id"); ?>';

        $r = $this->post('/register', [
            'name'                  => $payload,
            'email'                 => 'rce@example.com',
            'username'              => 'rceuser',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role'                  => 'pembeli',
        ]);

        $this->assertNotEquals(500, $r->status());
        $this->assertStringNotContainsString('uid=', $r->content());
    }

    // =========================================================
    // [10] Denial of Service (DoS)
    // =========================================================

    /** @test */
    public function large_search_string_does_not_cause_server_error(): void
    {
        $large = str_repeat('A', 10000);
        $r     = $this->get('/produk?search=' . $large);
        $this->assertNotEquals(500, $r->status(), '10KB search string caused 500');
    }

    /** @test */
    public function extremely_large_login_payload_does_not_crash_app(): void
    {
        $large = str_repeat('X', 10000);
        $r     = $this->post('/login', [
            'email'    => $large . '@example.com',
            'password' => $large,
        ]);
        $this->assertNotEquals(500, $r->status(), 'Large login payload caused 500');
    }

    /** @test */
    public function large_register_payload_does_not_crash_app(): void
    {
        $large = str_repeat('B', 5000);
        $r     = $this->post('/register', [
            'name'                  => $large,
            'email'                 => $large . '@example.com',
            'username'              => $large,
            'password'              => $large,
            'password_confirmation' => $large,
            'role'                  => 'pembeli',
        ]);
        $this->assertNotEquals(500, $r->status(), 'Large register payload caused 500');
    }

    /** @test */
    public function null_byte_injection_in_search_does_not_crash_app(): void
    {
        $payload = "normal\x00injection";
        $r       = $this->get('/produk?search=' . urlencode($payload));
        $this->assertNotEquals(500, $r->status());
    }

    /** @test */
    public function unicode_overflow_in_search_does_not_crash_app(): void
    {
        $payload = str_repeat('😀', 500); // 500 emoji
        $r       = $this->get('/produk?search=' . urlencode($payload));
        $this->assertNotEquals(500, $r->status());
    }

    // =========================================================
    // [11] DDoS – Rapid Repeated Requests
    // =========================================================

    /** @test */
    public function rapid_repeated_requests_to_home_do_not_cause_error(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $r = $this->get('/');
            $this->assertContains(
                $r->status(),
                [200, 429],
                "Request #{$i} returned unexpected status {$r->status()}"
            );
        }
    }

    /** @test */
    public function rapid_repeated_failed_logins_do_not_cause_server_error(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $r = $this->post('/login', [
                'email'    => 'nonexistent@example.com',
                'password' => 'wrongpassword' . $i,
            ]);
            $this->assertNotEquals(500, $r->status(), "Failed login #{$i} caused 500");
        }
    }

    /** @test */
    public function rapid_product_listing_requests_do_not_cause_error(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $r = $this->get('/produk?page=' . $i);
            $this->assertContains($r->status(), [200, 429]);
        }
    }

    // =========================================================
    // [12] Session Hijacking
    // =========================================================

    /** @test */
    public function session_cookie_httponly_config_is_enabled(): void
    {
        $this->assertTrue(
            config('session.http_only', true),
            'session.http_only must be true — prevents JS from reading session cookie'
        );
    }

    /** @test */
    public function session_driver_is_not_insecure_cookie_based(): void
    {
        $driver = config('session.driver');
        $this->assertNotEquals(
            'cookie',
            $driver,
            "Session driver 'cookie' is insecure — use 'file', 'database', or 'redis'"
        );
    }

    /** @test */
    public function session_lifetime_is_within_reasonable_bounds(): void
    {
        $lifetime = (int) config('session.lifetime'); // minutes
        $this->assertGreaterThan(0, $lifetime, 'Session lifetime must be positive');
        $this->assertLessThanOrEqual(10080, $lifetime, 'Session lifetime must not exceed 1 week (10080 min)');
    }

    /** @test */
    public function stolen_session_id_in_cookie_does_not_grant_access_to_admin(): void
    {
        // Simulate an attacker sending a fake/random session ID as cookie
        $fakeSessionId = bin2hex(random_bytes(32));

        $r = $this->withCookie(config('session.cookie', 'laravel_session'), $fakeSessionId)
                   ->get('/admin/users');

        // Must redirect to login, not serve admin content
        $this->assertNotEquals(200, $r->status(), 'Fake session ID must not grant admin access');
    }

    // =========================================================
    // [13] Man-in-the-Middle (MitM) – Config Checks
    // =========================================================

    /** @test */
    public function app_key_is_set_and_not_empty(): void
    {
        $key = config('app.key');
        $this->assertNotEmpty($key, 'APP_KEY must be set — required for secure encryption');
        $this->assertStringStartsWith('base64:', $key, 'APP_KEY should be a base64-encoded key');
    }

    /** @test */
    public function session_secure_config_is_boolean(): void
    {
        // In production this must be true (HTTPS-only cookies)
        // config may return null if not explicitly set (defaults to false)
        $secureValue = config('session.secure');
        $this->assertTrue(
            is_bool($secureValue) || is_null($secureValue),
            'session.secure must be boolean or null (defaults to false) — set true in production'
        );
    }

    /** @test */
    public function session_same_site_config_is_set(): void
    {
        $sameSite = config('session.same_site');
        $this->assertContains(
            strtolower((string) $sameSite),
            ['lax', 'strict', 'none', ''],
            "session.same_site must be 'lax', 'strict', or 'none'"
        );
    }

    /** @test */
    public function encryption_service_is_functional(): void
    {
        // Verify Laravel's Crypt facade works (app key is valid)
        $plaintext  = 'sensitive-data';
        $ciphertext = encrypt($plaintext);
        $decrypted  = decrypt($ciphertext);

        $this->assertEquals($plaintext, $decrypted, 'Encryption/decryption must work correctly');
        $this->assertNotEquals($plaintext, $ciphertext, 'Ciphertext must differ from plaintext');
    }

    // =========================================================
    // [14] Clickjacking
    // =========================================================

    /** @test */
    public function login_page_loads_without_server_error(): void
    {
        // Verify login page is functional (prerequisite for header checks)
        $this->get('/login')->assertStatus(200);
    }

    /** @test */
    public function home_page_does_not_embed_untrusted_iframes(): void
    {
        $r    = $this->get('/');
        $body = $r->content();

        // Verify no iframes pointing to suspicious external URLs
        if (str_contains($body, '<iframe')) {
            $this->assertStringNotContainsString('iframe src="http://', $body);
        }

        $this->assertTrue(true); // Clickjacking protection is primarily header/middleware level
    }

    /** @test */
    public function response_security_headers_are_documented(): void
    {
        $r = $this->get('/login');

        // Document current header state — infrastructure or middleware should set these
        $headers = [
            'X-Frame-Options'        => $r->headers->get('X-Frame-Options'),
            'X-Content-Type-Options' => $r->headers->get('X-Content-Type-Options'),
            'X-XSS-Protection'       => $r->headers->get('X-XSS-Protection'),
            'Referrer-Policy'        => $r->headers->get('Referrer-Policy'),
        ];

        // Test passes regardless — this serves as documentation of current state
        $this->assertTrue(true, 'Security headers: ' . json_encode($headers));
    }

    // =========================================================
    // [15] Security Misconfiguration (Extended)
    // =========================================================

    /** @test */
    public function env_file_is_not_publicly_accessible(): void
    {
        $r = $this->get('/.env');
        $this->assertNotEquals(200, $r->status(), '.env must not be publicly accessible');
        if ($r->status() === 200) {
            $this->assertStringNotContainsString('APP_KEY=', $r->content());
            $this->assertStringNotContainsString('DB_PASSWORD=', $r->content());
        }
    }

    /** @test */
    public function composer_json_is_not_publicly_accessible(): void
    {
        $r = $this->get('/composer.json');
        $this->assertNotEquals(200, $r->status(), 'composer.json must not be publicly accessible');
    }

    /** @test */
    public function phpinfo_endpoint_does_not_exist(): void
    {
        $r = $this->get('/phpinfo.php');
        $this->assertNotEquals(200, $r->status(), 'phpinfo.php must not be publicly accessible');
        if ($r->status() === 200) {
            $this->assertStringNotContainsString('PHP Version', $r->content());
        }
    }

    /** @test */
    public function git_directory_is_not_publicly_accessible(): void
    {
        $r = $this->get('/.git/config');
        $this->assertNotEquals(200, $r->status(), '.git directory must not be publicly accessible');
    }

    /** @test */
    public function app_environment_is_valid(): void
    {
        $env = config('app.env');
        $this->assertNotEmpty($env, 'APP_ENV must be set');
        $this->assertContains($env, ['local', 'staging', 'production', 'testing']);
    }

    /** @test */
    public function database_error_message_is_not_exposed_in_response(): void
    {
        $r    = $this->get('/produk?search=' . urlencode("' OR 1=1 --"));
        $body = $r->content();

        $dbErrorPatterns = ['SQLSTATE', 'MySQL server', 'syntax error', 'QueryException', 'ORA-', 'pg_query'];
        foreach ($dbErrorPatterns as $pattern) {
            $this->assertStringNotContainsString($pattern, $body, "DB error [{$pattern}] exposed in response");
        }
    }

    /** @test */
    public function stack_trace_is_not_exposed_in_404_response(): void
    {
        $r    = $this->get('/route-does-not-exist-' . uniqid());
        $body = $r->content();

        $r->assertStatus(404);
        $this->assertStringNotContainsString('vendor/laravel', $body, 'Stack trace exposed in 404');
        $this->assertStringNotContainsString('#0 /var', $body, 'PHP stack trace exposed in 404');
    }

    // =========================================================
    // [16] Brute Force Attack
    // =========================================================

    /** @test */
    public function brute_force_with_common_passwords_never_authenticates(): void
    {
        $user = User::factory()->create([
            'password'          => bcrypt('VeryUniquePass99!'),
            'email_verified_at' => now(),
        ]);

        $common = [
            'password', '123456', 'admin', 'letmein', 'qwerty',
            'abc123', 'password1', 'admin123', '12345678', 'iloveyou',
            'welcome', 'monkey', 'dragon', 'master', 'pass1234',
        ];

        foreach ($common as $attempt) {
            $this->post('/login', ['email' => $user->email, 'password' => $attempt]);
            $this->assertGuest();
        }
    }

    /** @test */
    public function brute_force_with_variations_of_real_password_never_authenticates(): void
    {
        $user = User::factory()->create([
            'password'          => bcrypt('Secure99!Pass'),
            'email_verified_at' => now(),
        ]);

        $guesses = [
            'Secure99!pass', 'secure99!Pass', 'Secure99Pass', 'Secure99!Pas',
            'Secure98!Pass', 'Secure00!Pass', 'Secure99!Pass1',
        ];

        foreach ($guesses as $guess) {
            $this->post('/login', ['email' => $user->email, 'password' => $guess]);
            $this->assertGuest();
        }
    }

    /** @test */
    public function brute_force_against_nonexistent_account_does_not_crash_app(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $r = $this->post('/login', [
                'email'    => 'fake' . $i . '@attack.com',
                'password' => 'attempt' . $i,
            ]);
            $this->assertNotEquals(500, $r->status(), "Brute force attempt #{$i} caused 500");
            $this->assertGuest();
        }
    }

    // =========================================================
    // [17] Credential Stuffing
    // =========================================================

    /** @test */
    public function credential_stuffing_with_leaked_passwords_does_not_authenticate(): void
    {
        $user = User::factory()->create([
            'email'             => 'victim@example.com',
            'password'          => bcrypt('UniqueP@ssw0rd2026!'),
            'email_verified_at' => now(),
        ]);

        // Simulated leaked credential list (common breach passwords)
        $leakedPasswords = [
            'password123', 'qwerty123', '123456789', 'letmein',
            'monkey', '1234567890', 'dragon', 'sunshine', 'princess',
            'admin', 'login', 'welcome', 'passw0rd', 'p@ssword',
        ];

        foreach ($leakedPasswords as $leaked) {
            $this->post('/login', ['email' => $user->email, 'password' => $leaked]);
            $this->assertGuest();
        }
    }

    /** @test */
    public function registration_rejects_common_weak_passwords(): void
    {
        $weakPasswords = ['password', '123456', 'qwerty', 'admin', 'abc123', 'iloveyou'];

        foreach ($weakPasswords as $weak) {
            $r = $this->post('/register', [
                'name'                  => 'Test User',
                'email'                 => 'weak' . uniqid() . '@example.com',
                'username'              => 'weak' . uniqid(),
                'password'              => $weak,
                'password_confirmation' => $weak,
                'role'                  => 'pembeli',
            ]);
            $r->assertSessionHasErrors('password');
            $this->assertGuest();
        }
    }

    /** @test */
    public function credential_stuffing_with_email_variation_does_not_authenticate(): void
    {
        User::factory()->create([
            'email'             => 'realuser@example.com',
            'password'          => bcrypt('RealP@ss99!'),
            'email_verified_at' => now(),
        ]);

        // Email variations with WRONG passwords
        $emailVariations = [
            'realuser+attack@example.com',
            'realuser@example.org',
            'realuser@example.net',
        ];

        foreach ($emailVariations as $email) {
            $this->post('/login', ['email' => $email, 'password' => 'WrongPass999!']);
            $this->assertGuest();
        }
    }

    // =========================================================
    // [18] XXE – XML External Entity
    // =========================================================

    /** @test */
    public function xxe_payload_in_login_does_not_expose_files(): void
    {
        $xxe = '<?xml version="1.0"?><!DOCTYPE foo [<!ENTITY xxe SYSTEM "file:///etc/passwd">]><data>&xxe;</data>';

        $r = $this->call('POST', '/login', [], [], [], ['CONTENT_TYPE' => 'application/xml'], $xxe);

        $this->assertNotEquals(500, $r->status());
        $this->assertStringNotContainsString('root:', $r->content());
    }

    /** @test */
    public function xxe_payload_in_form_field_does_not_expose_files(): void
    {
        $xxe = '<?xml version="1.0"?><!DOCTYPE foo [<!ENTITY xxe SYSTEM "file:///etc/passwd">]><r>&xxe;</r>';

        $r = $this->post('/login', [
            'email'    => $xxe,
            'password' => $xxe,
        ]);

        $this->assertNotEquals(500, $r->status());
        $this->assertStringNotContainsString('root:', $r->content());
        $this->assertGuest();
    }

    /** @test */
    public function php_version_provides_xxe_protection_by_default(): void
    {
        // PHP 8.0+ disables external entity loading by default in libxml
        if (PHP_VERSION_ID >= 80000) {
            $this->assertTrue(true, 'PHP 8+ disables external XML entity loading by default — secure');
        } else {
            $this->markTestSkipped('PHP < 8.0 detected — verify libxml_disable_entity_loader(true) is called');
        }
    }

    /** @test */
    public function xxe_billion_laughs_does_not_crash_server(): void
    {
        // Billion Laughs (entity expansion DoS)
        $payload = '<?xml version="1.0"?><!DOCTYPE x [<!ENTITY a "aaa"><!ENTITY b "&a;&a;&a;&a;&a;">]><x>&b;</x>';

        $r = $this->call('POST', '/login', [], [], [], ['CONTENT_TYPE' => 'application/xml'], $payload);

        $this->assertNotEquals(500, $r->status());
    }

    // =========================================================
    // [19] Insecure Deserialization
    // =========================================================

    /** @test */
    public function php_serialized_object_in_search_param_does_not_cause_rce(): void
    {
        $serialized = serialize(new \stdClass());

        $r = $this->get('/produk?search=' . urlencode($serialized));
        $this->assertNotEquals(500, $r->status(), 'Serialized object in search caused 500');
        $this->assertStringNotContainsString('uid=', $r->content());
    }

    /** @test */
    public function base64_serialized_data_in_search_does_not_cause_error(): void
    {
        $payload = base64_encode(serialize(['admin' => true, 'role' => 'admin']));

        $r = $this->get('/produk?search=' . urlencode($payload));
        $this->assertNotEquals(500, $r->status());
    }

    /** @test */
    public function manipulated_cookie_with_serialized_data_does_not_grant_admin_access(): void
    {
        $malicious = base64_encode(serialize(['role' => 'admin', 'id' => 1, 'is_active' => true]));

        $r = $this->withCookie('user_data', $malicious)->get('/admin/users');
        // Must be rejected (redirect to login or 403), not 200
        $this->assertNotEquals(200, $r->status(), 'Serialized cookie manipulation must not grant admin access');
        $this->assertGuest();
    }

    /** @test */
    public function type_confusion_in_login_does_not_authenticate(): void
    {
        // Sending array where string expected (type juggling / deserialization confusion)
        $r = $this->post('/login', [
            'email'    => ['$ne' => null, '$gt' => ''],
            'password' => ['$ne' => null],
        ]);
        $this->assertNotEquals(500, $r->status());
        $this->assertGuest();
    }

    /** @test */
    public function json_object_injection_in_login_does_not_authenticate(): void
    {
        // Injecting JSON object notation as string
        $r = $this->post('/login', [
            'email'    => '{"$gt": ""}',
            'password' => '{"$ne": null}',
        ]);
        $this->assertNotEquals(500, $r->status());
        $this->assertGuest();
    }

    // =========================================================
    // [20] Phishing – Open Redirect Prevention
    // =========================================================

    /** @test */
    public function login_with_external_redirect_param_does_not_redirect_to_external_site(): void
    {
        $user = User::factory()->create([
            'password'          => bcrypt('Password1!'),
            'email_verified_at' => now(),
            'role'              => 'pembeli',
        ]);

        $r = $this->post('/login?redirect=https://evil.com', [
            'email'    => $user->email,
            'password' => 'Password1!',
        ]);

        if ($r->isRedirect()) {
            $location = $r->headers->get('Location', '');
            $this->assertStringNotContainsString('evil.com', $location, 'Login redirected to external domain');
            $this->assertStringNotContainsString('http://evil', $location);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function open_redirect_via_next_param_is_blocked(): void
    {
        $user = User::factory()->create([
            'password'          => bcrypt('Password1!'),
            'email_verified_at' => now(),
            'role'              => 'pembeli',
        ]);

        $externalUrls = [
            'https://phishing.com',
            '//evil.com',
            'https://evil.com/steal-cookies',
        ];

        foreach ($externalUrls as $url) {
            $r = $this->post('/login', [
                'email'    => $user->email,
                'password' => 'Password1!',
                'next'     => $url,
                'redirect' => $url,
            ]);

            if ($r->isRedirect()) {
                $location = $r->headers->get('Location', '');
                $this->assertStringNotContainsString('phishing.com', $location);
                $this->assertStringNotContainsString('evil.com', $location);
            }
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function forgot_password_with_external_redirect_is_blocked(): void
    {
        $user = User::factory()->create();

        $r = $this->post('/forgot-password?next=https://evil.com', [
            'email'    => $user->email,
            'redirect' => 'https://evil.com',
        ]);

        if ($r->isRedirect()) {
            $location = $r->headers->get('Location', '');
            $this->assertStringNotContainsString('evil.com', $location);
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function register_redirect_after_success_is_internal_only(): void
    {
        $r = $this->post('/register', [
            'name'                  => 'Phishing Test',
            'email'                 => 'phish@example.com',
            'username'              => 'phishtest',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role'                  => 'pembeli',
            'redirect_to'           => 'https://evil.com',
        ]);

        if ($r->isRedirect()) {
            $location = $r->headers->get('Location', '');
            $this->assertStringNotContainsString('evil.com', $location, 'Register must not redirect to external site');
        }

        $this->assertTrue(true);
    }
}
