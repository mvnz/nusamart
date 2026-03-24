<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function authenticatedUser(): User
    {
        $user = User::factory()->create(['password' => 'Password1!']);
        $this->actingAs($user);
        return $user;
    }

    // ===== PROFILE PAGE =====

    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    public function test_profile_page_requires_verified_email(): void
    {
        $user = User::factory()->unverified()->create();
        $this->actingAs($user);

        $response = $this->get('/profile');
        $response->assertRedirect(route('verification.notice'));
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $this->authenticatedUser();

        $response = $this->get('/profile');
        $response->assertStatus(200);
    }

    // ===== PROFILE UPDATE =====

    public function test_user_can_update_profile(): void
    {
        $user = $this->authenticatedUser();

        $response = $this->put('/profile', [
            'name' => 'Updated Name',
            'username' => $user->username,
            'email' => $user->email,
            'phone' => '089999999999',
            'alamat' => 'Jl. Baru No. 1',
            'province_code' => '32',
            'regency_code' => '3204',
            'district_code' => '3204010',
            'village_code' => '3204010001',
            'propinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Astanaanyar',
            'kelurahan' => 'Karasak',
            'rt' => '001',
            'rw' => '002',
            'kodepos' => '40243',
        ]);

        $response->assertRedirect(route('profile'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'kota' => 'Bandung',
        ]);
    }

    public function test_profile_update_validates_required_fields(): void
    {
        $this->authenticatedUser();

        $response = $this->put('/profile', []);
        $response->assertSessionHasErrors(['name', 'username', 'email', 'phone', 'alamat', 'province_code', 'regency_code', 'district_code', 'village_code', 'rt', 'rw', 'kodepos']);
    }

    public function test_profile_update_allows_own_email(): void
    {
        $user = $this->authenticatedUser();

        $response = $this->put('/profile', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
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
        ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHasNoErrors();
    }

    public function test_profile_update_rejects_taken_email(): void
    {
        $this->authenticatedUser();
        User::factory()->create(['email' => 'other@example.com']);

        $response = $this->put('/profile', [
            'name' => 'Test',
            'username' => 'unique_user',
            'email' => 'other@example.com',
            'phone' => '081234567890',
            'alamat' => 'Jl.',
            'kota' => 'Jakarta',
            'propinsi' => 'DKI',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // ===== PHOTO UPLOAD =====

    public function test_user_can_upload_profile_photo(): void
    {
        $user = $this->authenticatedUser();
        $user = User::find($user->id);

        $file = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->post('/profile/photo', [
            'photo' => $file,
        ]);

        $response->assertRedirect(route('profile'));
        $user->refresh();
        $this->assertNotNull($user->photo);
    }

    public function test_photo_upload_rejects_non_image(): void
    {
        $this->authenticatedUser();

        $response = $this->post('/profile/photo', [
            'photo' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_photo_upload_rejects_oversized_file(): void
    {
        $this->authenticatedUser();

        $response = $this->post('/profile/photo', [
            'photo' => UploadedFile::fake()->create('big.jpg', 3000, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_user_can_delete_profile_photo(): void
    {
        $user = User::factory()->create(['password' => 'Password1!', 'photo' => 'photos/test.jpg']);
        $this->actingAs($user);

        $response = $this->delete('/profile/photo');

        $response->assertRedirect(route('profile'));
        $user->refresh();
        $this->assertNull($user->photo);
    }

    // ===== CHANGE PASSWORD =====

    public function test_change_password_page_is_accessible(): void
    {
        $this->authenticatedUser();

        $response = $this->get('/profile/password');
        $response->assertStatus(200);
    }

    public function test_user_can_change_password(): void
    {
        $user = $this->authenticatedUser();

        $response = $this->put('/profile/password', [
            'current_password' => 'Password1!',
            'password' => 'NewPassword2@',
            'password_confirmation' => 'NewPassword2@',
        ]);

        $response->assertRedirect(route('profile.password'));
        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword2@', $user->password));
    }

    public function test_change_password_fails_with_wrong_current_password(): void
    {
        $this->authenticatedUser();

        $response = $this->put('/profile/password', [
            'current_password' => 'WrongPassword1!',
            'password' => 'NewPassword2@',
            'password_confirmation' => 'NewPassword2@',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    public function test_change_password_requires_strong_password(): void
    {
        $this->authenticatedUser();

        $response = $this->put('/profile/password', [
            'current_password' => 'Password1!',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_change_password_requires_confirmation(): void
    {
        $this->authenticatedUser();

        $response = $this->put('/profile/password', [
            'current_password' => 'Password1!',
            'password' => 'NewPassword2@',
            'password_confirmation' => 'Mismatch2@',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
