<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class E2EPasswordResetFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_forgot_password_to_login_flow(): void
    {
        // Step 1: Create user
        $user = User::factory()->create([
            'password' => 'OldPassword1!',
        ]);

        // Step 2: Visit forgot password page
        $this->get('/forgot-password')->assertStatus(200);

        // Step 3: Submit email for reset link
        $this->post('/forgot-password', [
            'email' => $user->email,
        ])->assertSessionHas('success');

        // Step 4: Verify token was created
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->first();
        $this->assertNotNull($tokenRecord);

        // Step 5: Simulate visiting reset form with a known token
        // We need to insert a known token since the real one is hashed
        $plainToken = 'test-reset-token-12345';
        DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->update(['token' => Hash::make($plainToken)]);

        $this->get("/reset-password/{$plainToken}?email={$user->email}")
            ->assertStatus(200);

        // Step 6: Reset the password
        $this->post('/reset-password', [
            'token' => $plainToken,
            'email' => $user->email,
            'password' => 'BrandNew1!',
            'password_confirmation' => 'BrandNew1!',
        ])->assertRedirect(route('login'));

        // Step 7: Token should be deleted
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);

        // Step 8: Login with new password
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'BrandNew1!',
        ]);
        $this->assertAuthenticated();

        // Step 9: Old password no longer works
        $this->post('/logout');
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'OldPassword1!',
        ]);
        $this->assertGuest();
    }
}
