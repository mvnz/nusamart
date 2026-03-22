<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // ===== LOGIN =====

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'Password1!',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => 'Password1!',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPass1!',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_email_and_password(): void
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_unverified_user_redirected_to_verification(): void
    {
        $user = User::factory()->unverified()->create([
            'password' => 'Password1!',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice'));
    }

    // ===== LOGOUT =====

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // ===== REGISTRATION =====

    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role' => 'pembeli',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
            'role' => 'pembeli',
        ]);
    }

    public function test_registration_requires_all_fields(): void
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors([
            'nama_lengkap', 'username', 'email', 'phone',
            'alamat', 'kota', 'propinsi', 'password', 'role',
        ]);
    }

    public function test_registration_rejects_weak_password(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'weakpass',
            'password_confirmation' => 'weakpass',
            'role' => 'pembeli',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_rejects_password_without_uppercase(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'testuser2',
            'email' => 'test2@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'password1!',
            'password_confirmation' => 'password1!',
            'role' => 'pembeli',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_rejects_password_without_special_char(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'testuser3',
            'email' => 'test3@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
            'role' => 'pembeli',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'testuser4',
            'email' => 'taken@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role' => 'pembeli',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_rejects_duplicate_username(): void
    {
        User::factory()->create(['username' => 'takenuser']);

        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'takenuser',
            'email' => 'new@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role' => 'pembeli',
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_registration_rejects_invalid_role(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'Test User',
            'username' => 'testuser5',
            'email' => 'test5@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl. Test',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI Jakarta',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
            'role' => 'admin',
        ]);

        $response->assertSessionHasErrors('role');
    }
}
