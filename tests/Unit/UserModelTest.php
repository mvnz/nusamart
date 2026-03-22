<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_factory(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_user_has_fillable_attributes(): void
    {
        $user = new User();
        $fillable = $user->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('email', $fillable);
        $this->assertContains('username', $fillable);
        $this->assertContains('phone', $fillable);
        $this->assertContains('alamat', $fillable);
        $this->assertContains('kota', $fillable);
        $this->assertContains('propinsi', $fillable);
        $this->assertContains('password', $fillable);
        $this->assertContains('role', $fillable);
        $this->assertContains('photo', $fillable);
    }

    public function test_user_has_hidden_attributes(): void
    {
        $user = new User();
        $hidden = $user->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create(['password' => 'Password1!']);

        $this->assertNotEquals('Password1!', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('Password1!', $user->password));
    }

    public function test_user_default_role_is_pembeli(): void
    {
        $user = User::factory()->create();

        $this->assertEquals('pembeli', $user->role);
    }

    public function test_user_can_be_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertEquals('admin', $user->role);
    }

    public function test_user_can_be_penjual(): void
    {
        $user = User::factory()->penjual()->create();

        $this->assertEquals('penjual', $user->role);
    }

    public function test_user_can_be_unverified(): void
    {
        $user = User::factory()->unverified()->create();

        $this->assertNull($user->email_verified_at);
        $this->assertFalse($user->hasVerifiedEmail());
    }

    public function test_user_email_verified_at_is_cast_to_datetime(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }

    public function test_user_implements_must_verify_email(): void
    {
        $user = new User();

        $this->assertInstanceOf(\Illuminate\Contracts\Auth\MustVerifyEmail::class, $user);
    }
}
