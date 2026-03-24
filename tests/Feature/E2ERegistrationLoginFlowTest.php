<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class E2ERegistrationLoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_registration_to_dashboard_flow(): void
    {
        // Step 1: User visits register page
        $this->get('/register')->assertStatus(200);

        // Step 2: User submits registration form
        $response = $this->post('/register', [
            'nama_lengkap' => 'Budi Santoso',
            'username' => 'budisantoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10',
            'province_code' => '31',
            'regency_code' => '3171',
            'district_code' => '3171010',
            'village_code' => '3171010001',
            'propinsi' => 'DKI Jakarta',
            'kota' => 'Jakarta Pusat',
            'kecamatan' => 'Gambir',
            'kelurahan' => 'Gambir',
            'rt' => '001',
            'rw' => '001',
            'kodepos' => '10110',
            'password' => 'BudiPass1!',
            'password_confirmation' => 'BudiPass1!',
            'role' => 'pembeli',
        ]);

        // Step 3: User is authenticated and redirected to email verification
        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice'));

        // Step 4: Verify user exists in database
        $user = User::where('email', 'budi@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Budi Santoso', $user->name);
        $this->assertEquals('pembeli', $user->role);
        $this->assertNull($user->email_verified_at);

        // Step 5: Unverified user cannot access dashboard
        $this->get('/dashboard')->assertRedirect(route('verification.notice'));

        // Step 6: Simulate email verification
        $user->markEmailAsVerified();
        $user->refresh();

        // Step 7: Re-login to refresh session, then access dashboard
        $this->post('/logout');
        $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'BudiPass1!',
        ]);
        $this->get('/dashboard')->assertStatus(200);
    }

    public function test_full_login_to_profile_update_flow(): void
    {
        // Step 1: Create a verified user
        $user = User::factory()->create([
            'password' => 'Password1!',
            'name' => 'Original Name',
        ]);

        // Step 2: Login
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);
        $this->assertAuthenticated();

        // Step 3: Visit profile page
        $this->get('/profile')->assertStatus(200);

        // Step 4: Update profile
        $this->put('/profile', [
            'name' => 'Updated Name',
            'username' => $user->username,
            'email' => $user->email,
            'phone' => '089999999999',
            'alamat' => 'Jl. Baru No. 5',
            'province_code' => '35',
            'regency_code' => '3578',
            'district_code' => '3578010',
            'village_code' => '3578010001',
            'propinsi' => 'Jawa Timur',
            'kota' => 'Surabaya',
            'kecamatan' => 'Genteng',
            'kelurahan' => 'Genteng',
            'rt' => '001',
            'rw' => '001',
            'kodepos' => '60274',
        ])->assertRedirect(route('profile'));

        // Step 5: Verify update persisted
        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('Surabaya', $user->kota);

        // Step 6: Change password
        $this->get('/profile/password')->assertStatus(200);
        $this->put('/profile/password', [
            'current_password' => 'Password1!',
            'password' => 'NewSecure2@',
            'password_confirmation' => 'NewSecure2@',
        ])->assertRedirect(route('profile.password'));

        // Step 7: Logout
        $this->post('/logout');
        $this->assertGuest();

        // Step 8: Login with new password
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'NewSecure2@',
        ]);
        $this->assertAuthenticated();
    }

    public function test_full_seller_registration_flow(): void
    {
        // Step 1: Register as penjual
        $this->post('/register', [
            'nama_lengkap' => 'Pak Toko',
            'username' => 'paktoko',
            'email' => 'paktoko@example.com',
            'phone' => '081000000001',
            'alamat' => 'Desa Manud Jaya',
            'province_code' => '31',
            'regency_code' => '3171',
            'district_code' => '3171010',
            'village_code' => '3171010001',
            'propinsi' => 'DKI Jakarta',
            'kota' => 'Jakarta Pusat',
            'kecamatan' => 'Gambir',
            'kelurahan' => 'Gambir',
            'rt' => '001',
            'rw' => '001',
            'kodepos' => '10110',
            'password' => 'SellerPass1!',
            'password_confirmation' => 'SellerPass1!',
            'role' => 'penjual',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'paktoko@example.com')->first();
        $this->assertEquals('penjual', $user->role);

        // Step 2: Verify email and re-login to refresh session
        $user->markEmailAsVerified();
        $this->post('/logout');
        $this->post('/login', [
            'email' => 'paktoko@example.com',
            'password' => 'SellerPass1!',
        ]);

        // Step 3: Access dashboard
        $this->get('/dashboard')->assertStatus(200);
    }
}
