<?php

namespace Tests\Feature;

use App\Models\Kuliner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class KulinerTest extends TestCase
{
    use RefreshDatabase;

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    private function adminUser(): User
    {
        return User::factory()->admin()->create();
    }

    private function regularUser(): User
    {
        return User::factory()->create(['role' => 'pembeli']);
    }

    private function makeKuliner(array $overrides = []): Kuliner
    {
        return Kuliner::create(array_merge([
            'nama'      => 'Warung Makan Sederhana',
            'deskripsi' => 'Warung makan khas Jawa Tengah yang lezat.',
            'gambar'    => 'kuliner/test.jpg',
            'alamat'    => 'Jl. Mawar No. 5, Semarang',
            'jam_buka'  => '08:00',
            'jam_tutup' => '21:00',
            'kontak_wa' => '081234567890',
            'kategori'  => 'Nasi',
            'link_maps' => null,
            'status'    => 'buka',
        ], $overrides));
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'nama'      => 'Warung Baru',
            'deskripsi' => 'Deskripsi warung baru yang lengkap.',
            'alamat'    => 'Jl. Kenanga No. 10',
            'jam_buka'  => '07:00',
            'jam_tutup' => '22:00',
            'kontak_wa' => '081298765432',
            'kategori'  => 'Mie',
            'link_maps' => null,
            'status'    => 'buka',
        ], $overrides);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure kuliner upload directory exists for tests
        $uploadDir = public_path('uploads/kuliner');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    }

    // ================================================================
    // [1] PUBLIC ROUTES
    // ================================================================

    public function test_guest_can_view_kuliner_index(): void
    {
        $this->makeKuliner(['nama' => 'Warung Soto']);

        $response = $this->get('/kuliner');

        $response->assertStatus(200);
        $response->assertSee('Warung Soto');
    }

    public function test_kuliner_index_shows_all_entries(): void
    {
        $this->makeKuliner(['nama' => 'Warung A']);
        $this->makeKuliner(['nama' => 'Warung B']);

        $response = $this->get('/kuliner');

        $response->assertStatus(200);
        $response->assertSee('Warung A');
        $response->assertSee('Warung B');
    }

    public function test_guest_can_view_kuliner_detail(): void
    {
        $kuliner = $this->makeKuliner(['nama' => 'Warung Detail']);

        $response = $this->get("/kuliner/{$kuliner->id}");

        $response->assertStatus(200);
        $response->assertSee('Warung Detail');
    }

    public function test_kuliner_detail_shows_full_info(): void
    {
        $kuliner = $this->makeKuliner([
            'nama'      => 'Warung Info',
            'deskripsi' => 'Deskripsi lengkap warung ini.',
            'alamat'    => 'Jl. Info No. 1',
            'kontak_wa' => '082100000000',
        ]);

        $response = $this->get("/kuliner/{$kuliner->id}");

        $response->assertStatus(200);
        $response->assertSee('Warung Info');
        $response->assertSee('Jl. Info No. 1');
    }

    public function test_kuliner_detail_returns_404_for_nonexistent_id(): void
    {
        $response = $this->get('/kuliner/99999');

        $response->assertStatus(404);
    }

    // ================================================================
    // [2] ADMIN INDEX & ACCESS CONTROL
    // ================================================================

    public function test_guest_cannot_access_admin_kuliner_index(): void
    {
        $response = $this->get('/admin/kuliner');

        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_admin_kuliner_index(): void
    {
        $this->actingAs($this->regularUser());

        $response = $this->get('/admin/kuliner');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_kuliner_index(): void
    {
        $this->actingAs($this->adminUser());
        $this->makeKuliner(['nama' => 'Warung Admin']);

        $response = $this->get('/admin/kuliner');

        $response->assertStatus(200);
        $response->assertSee('Warung Admin');
    }

    // ================================================================
    // [3] ADMIN CREATE FORM
    // ================================================================

    public function test_admin_can_access_kuliner_create_form(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->get('/admin/kuliner/create');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_kuliner_create_form(): void
    {
        $this->actingAs($this->regularUser());

        $response = $this->get('/admin/kuliner/create');

        $response->assertStatus(403);
    }

    // ================================================================
    // [4] ADMIN STORE (CREATE)
    // ================================================================

    public function test_admin_can_create_kuliner(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(['nama' => 'Warung Baru Test']),
            ['gambar' => UploadedFile::fake()->create('warung.jpg', 100, 'image/jpeg')]
        ));

        $response->assertRedirect(route('admin.kuliner.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kuliners', ['nama' => 'Warung Baru Test']);
    }

    public function test_kuliner_store_rejects_missing_nama(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(['nama' => '']),
            ['gambar' => UploadedFile::fake()->create('warung.jpg', 100, 'image/jpeg')]
        ));

        $response->assertSessionHasErrors('nama');
    }

    public function test_kuliner_store_rejects_missing_deskripsi(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(['deskripsi' => '']),
            ['gambar' => UploadedFile::fake()->create('warung.jpg', 100, 'image/jpeg')]
        ));

        $response->assertSessionHasErrors('deskripsi');
    }

    public function test_kuliner_store_requires_gambar(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', $this->validPayload());

        $response->assertSessionHasErrors('gambar');
    }

    public function test_kuliner_store_rejects_non_image_gambar(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(),
            ['gambar' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf')]
        ));

        $response->assertSessionHasErrors('gambar');
    }

    public function test_kuliner_store_rejects_oversized_gambar(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(),
            ['gambar' => UploadedFile::fake()->create('big.jpg', 3000, 'image/jpeg')]
        ));

        $response->assertSessionHasErrors('gambar');
    }

    public function test_kuliner_store_rejects_invalid_link_maps(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(['link_maps' => 'bukan-url']),
            ['gambar' => UploadedFile::fake()->create('warung.jpg', 100, 'image/jpeg')]
        ));

        $response->assertSessionHasErrors('link_maps');
    }

    public function test_kuliner_store_rejects_invalid_status(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload(['status' => 'invalid']),
            ['gambar' => UploadedFile::fake()->create('warung.jpg', 100, 'image/jpeg')]
        ));

        $response->assertSessionHasErrors('status');
    }

    public function test_kuliner_store_accepts_valid_link_maps(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->post('/admin/kuliner', array_merge(
            $this->validPayload([
                'nama'      => 'Warung Maps',
                'link_maps' => 'https://maps.google.com/?q=semarang',
            ]),
            ['gambar' => UploadedFile::fake()->create('warung.jpg', 100, 'image/jpeg')]
        ));

        $response->assertSessionDoesntHaveErrors('link_maps');
        $this->assertDatabaseHas('kuliners', ['nama' => 'Warung Maps']);
    }

    // ================================================================
    // [5] ADMIN EDIT FORM
    // ================================================================

    public function test_admin_can_access_kuliner_edit_form(): void
    {
        $this->actingAs($this->adminUser());
        $kuliner = $this->makeKuliner();

        $response = $this->get("/admin/kuliner/{$kuliner->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($kuliner->nama);
    }

    public function test_non_admin_cannot_access_kuliner_edit_form(): void
    {
        $this->actingAs($this->regularUser());
        $kuliner = $this->makeKuliner();

        $response = $this->get("/admin/kuliner/{$kuliner->id}/edit");

        $response->assertStatus(403);
    }

    // ================================================================
    // [6] ADMIN UPDATE
    // ================================================================

    public function test_admin_can_update_kuliner_without_new_image(): void
    {
        $this->actingAs($this->adminUser());
        $kuliner = $this->makeKuliner(['nama' => 'Nama Lama']);

        $response = $this->put("/admin/kuliner/{$kuliner->id}", $this->validPayload(['nama' => 'Nama Baru']));

        $response->assertRedirect(route('admin.kuliner.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kuliners', ['id' => $kuliner->id, 'nama' => 'Nama Baru']);
    }

    public function test_admin_can_update_kuliner_with_new_image(): void
    {
        $this->actingAs($this->adminUser());
        $kuliner = $this->makeKuliner(['nama' => 'Warung Update']);

        $response = $this->put("/admin/kuliner/{$kuliner->id}", array_merge(
            $this->validPayload(['nama' => 'Warung Updated']),
            ['gambar' => UploadedFile::fake()->create('new.jpg', 100, 'image/jpeg')]
        ));

        $response->assertRedirect(route('admin.kuliner.index'));
        $this->assertDatabaseHas('kuliners', ['id' => $kuliner->id, 'nama' => 'Warung Updated']);
    }

    public function test_kuliner_update_rejects_missing_required_fields(): void
    {
        $this->actingAs($this->adminUser());
        $kuliner = $this->makeKuliner();

        $response = $this->put("/admin/kuliner/{$kuliner->id}", [
            'nama'      => '',
            'deskripsi' => '',
            'alamat'    => '',
            'jam_buka'  => '',
            'jam_tutup' => '',
            'kontak_wa' => '',
            'kategori'  => '',
            'status'    => '',
        ]);

        $response->assertSessionHasErrors(['nama', 'deskripsi', 'alamat', 'status']);
    }

    public function test_kuliner_update_rejects_non_image_gambar(): void
    {
        $this->actingAs($this->adminUser());
        $kuliner = $this->makeKuliner();

        $response = $this->put("/admin/kuliner/{$kuliner->id}", array_merge(
            $this->validPayload(),
            ['gambar' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf')]
        ));

        $response->assertSessionHasErrors('gambar');
    }

    public function test_kuliner_update_returns_404_for_nonexistent(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->put('/admin/kuliner/99999', $this->validPayload());

        $response->assertStatus(404);
    }

    // ================================================================
    // [7] ADMIN DESTROY
    // ================================================================

    public function test_admin_can_delete_kuliner(): void
    {
        $this->actingAs($this->adminUser());
        $kuliner = $this->makeKuliner(['nama' => 'Warung Hapus']);

        $response = $this->delete("/admin/kuliner/{$kuliner->id}");

        $response->assertRedirect(route('admin.kuliner.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('kuliners', ['id' => $kuliner->id]);
    }

    public function test_non_admin_cannot_delete_kuliner(): void
    {
        $this->actingAs($this->regularUser());
        $kuliner = $this->makeKuliner();

        $response = $this->delete("/admin/kuliner/{$kuliner->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('kuliners', ['id' => $kuliner->id]);
    }

    public function test_guest_cannot_delete_kuliner(): void
    {
        $kuliner = $this->makeKuliner();

        $response = $this->delete("/admin/kuliner/{$kuliner->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('kuliners', ['id' => $kuliner->id]);
    }

    public function test_kuliner_destroy_returns_404_for_nonexistent(): void
    {
        $this->actingAs($this->adminUser());

        $response = $this->delete('/admin/kuliner/99999');

        $response->assertStatus(404);
    }
}
