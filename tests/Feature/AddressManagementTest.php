<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressManagementTest extends TestCase
{
    use RefreshDatabase;

    // ===== HELPERS =====

    private function user(): User
    {
        return User::factory()->create();
    }

    private function addressPayload(array $overrides = []): array
    {
        return array_merge([
            'label'          => 'Rumah',
            'recipient_name' => 'Budi Santoso',
            'phone'          => '081234567890',
            'alamat'         => 'Jl. Merdeka No.1',
            'province_code'  => '32',
            'regency_code'   => '3273',
            'district_code'  => '327301',
            'village_code'   => '3273010001',
            'propinsi'       => 'Jawa Barat',
            'kota'           => 'Kota Bandung',
            'kecamatan'      => 'Kecamatan Coblong',
            'kelurahan'      => 'Kelurahan Dago',
            'rt'             => '001',
            'rw'             => '002',
            'kodepos'        => '40135',
        ], $overrides);
    }

    private function createAddress(User $user, array $attrs = []): UserAddress
    {
        return UserAddress::create(array_merge([
            'user_id'        => $user->id,
            'label'          => 'Rumah',
            'recipient_name' => 'Budi',
            'phone'          => '081234567890',
            'alamat'         => 'Jl. Test No.1',
            'province_code'  => '32',
            'regency_code'   => '3273',
            'district_code'  => '327301',
            'village_code'   => '3273010001',
            'propinsi'       => 'Jawa Barat',
            'kota'           => 'Bandung',
            'kecamatan'      => 'Coblong',
            'kelurahan'      => 'Dago',
            'rt'             => '001',
            'rw'             => '002',
            'kodepos'        => '40135',
            'is_primary'     => false,
        ], $attrs));
    }

    // ===== AUTH GUARD =====

    public function test_address_index_requires_authentication(): void
    {
        $this->get('/profile/alamat')->assertRedirect('/login');
    }

    public function test_store_address_requires_authentication(): void
    {
        $this->post('/profile/alamat', $this->addressPayload())->assertRedirect('/login');
    }

    // ===== INDEX =====

    public function test_user_can_view_address_list(): void
    {
        $user = $this->user();
        $this->actingAs($user)->get('/profile/alamat')->assertStatus(200);
    }

    public function test_address_index_shows_user_own_addresses(): void
    {
        $user    = $this->user();
        $address = $this->createAddress($user, ['label' => 'Kantor Utama']);

        $this->actingAs($user)
             ->get('/profile/alamat')
             ->assertStatus(200)
             ->assertSee('Kantor Utama');
    }

    // ===== STORE =====

    public function test_user_can_add_address(): void
    {
        $user = $this->user();

        $this->actingAs($user)
             ->post('/profile/alamat', $this->addressPayload())
             ->assertRedirect(route('profile.alamat'));

        $this->assertDatabaseHas('user_addresses', [
            'user_id' => $user->id,
            'label'   => 'Rumah',
            'kota'    => 'Kota Bandung',
        ]);
    }

    public function test_first_address_is_automatically_set_as_primary(): void
    {
        $user = $this->user();

        $this->actingAs($user)
             ->post('/profile/alamat', $this->addressPayload());

        $address = UserAddress::where('user_id', $user->id)->first();
        $this->assertTrue((bool) $address->is_primary);
    }

    public function test_second_address_is_not_automatically_primary(): void
    {
        $user = $this->user();
        $this->createAddress($user, ['is_primary' => true]);

        $this->actingAs($user)
             ->post('/profile/alamat', $this->addressPayload(['label' => 'Kantor']));

        $second = UserAddress::where('user_id', $user->id)
            ->where('label', 'Kantor')
            ->first();

        $this->assertFalse((bool) $second->is_primary);
    }

    public function test_store_address_validates_required_fields(): void
    {
        $user = $this->user();

        $this->actingAs($user)
             ->post('/profile/alamat', [])
             ->assertSessionHasErrors(['label', 'recipient_name', 'phone', 'alamat']);
    }

    public function test_store_validates_kodepos_must_be_5_digits(): void
    {
        $user = $this->user();

        $this->actingAs($user)
             ->post('/profile/alamat', $this->addressPayload(['kodepos' => '123']))
             ->assertSessionHasErrors(['kodepos']);
    }

    // ===== UPDATE =====

    public function test_user_can_update_own_address(): void
    {
        $user    = $this->user();
        $address = $this->createAddress($user);

        $this->actingAs($user)
             ->put("/profile/alamat/{$address->id}", $this->addressPayload(['label' => 'Gudang']))
             ->assertRedirect(route('profile.alamat'));

        $this->assertDatabaseHas('user_addresses', [
            'id'    => $address->id,
            'label' => 'Gudang',
        ]);
    }

    public function test_user_cannot_update_another_users_address(): void
    {
        $user1   = $this->user();
        $user2   = $this->user();
        $address = $this->createAddress($user2);

        $this->actingAs($user1)
             ->put("/profile/alamat/{$address->id}", $this->addressPayload())
             ->assertStatus(403);
    }

    // ===== DESTROY =====

    public function test_user_can_delete_non_primary_address(): void
    {
        $user    = $this->user();
        $primary = $this->createAddress($user, ['is_primary' => true, 'label' => 'Utama']);
        $other   = $this->createAddress($user, ['is_primary' => false, 'label' => 'Lain']);

        $this->actingAs($user)
             ->delete("/profile/alamat/{$other->id}")
             ->assertRedirect(route('profile.alamat'));

        $this->assertDatabaseMissing('user_addresses', ['id' => $other->id]);
    }

    public function test_user_cannot_delete_primary_address(): void
    {
        $user    = $this->user();
        $primary = $this->createAddress($user, ['is_primary' => true]);

        $this->actingAs($user)
             ->delete("/profile/alamat/{$primary->id}")
             ->assertStatus(422);
    }

    public function test_user_cannot_delete_another_users_address(): void
    {
        $user1   = $this->user();
        $user2   = $this->user();
        $address = $this->createAddress($user2, ['is_primary' => false]);

        $this->actingAs($user1)
             ->delete("/profile/alamat/{$address->id}")
             ->assertStatus(403);
    }

    // ===== SET PRIMARY =====

    public function test_user_can_set_primary_address(): void
    {
        $user    = $this->user();
        $primary = $this->createAddress($user, ['is_primary' => true, 'label' => 'Lama']);
        $other   = $this->createAddress($user, ['is_primary' => false, 'label' => 'Baru', 'kota' => 'Surabaya']);

        $this->actingAs($user)
             ->post("/profile/alamat/{$other->id}/primary")
             ->assertRedirect(route('profile.alamat'));

        $this->assertDatabaseHas('user_addresses', ['id' => $other->id, 'is_primary' => true]);
        $this->assertDatabaseHas('user_addresses', ['id' => $primary->id, 'is_primary' => false]);
    }

    public function test_set_primary_syncs_address_to_user_profile(): void
    {
        $user    = $this->user();
        $primary = $this->createAddress($user, ['is_primary' => true]);
        $other   = $this->createAddress($user, [
            'is_primary' => false,
            'kota'       => 'Surabaya',
            'propinsi'   => 'Jawa Timur',
        ]);

        $this->actingAs($user)
             ->post("/profile/alamat/{$other->id}/primary");

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'kota' => 'Surabaya',
        ]);
    }

    public function test_user_cannot_set_another_users_address_as_primary(): void
    {
        $user1   = $this->user();
        $user2   = $this->user();
        $address = $this->createAddress($user2, ['is_primary' => false]);

        $this->actingAs($user1)
             ->post("/profile/alamat/{$address->id}/primary")
             ->assertStatus(403);
    }
}
