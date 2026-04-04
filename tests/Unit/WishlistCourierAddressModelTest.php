<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Courier;
use App\Models\CourierService;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistCourierAddressModelTest extends TestCase
{
    use RefreshDatabase;

    private function makeWishlist(): Wishlist
    {
        $buyer    = User::factory()->create(['role' => 'pembeli']);
        $seller   = User::factory()->penjual()->create();
        $category = Category::create(['name' => 'Test']);
        $product  = Product::create([
            'user_id'     => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Produk WL',
            'price'       => 10000,
            'stock'       => 5,
            'is_active'   => true,
        ]);

        return Wishlist::create([
            'user_id'    => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_wishlist_has_fillable_attributes(): void
    {
        $wl       = new Wishlist();
        $fillable = $wl->getFillable();

        $this->assertContains('user_id', $fillable);
        $this->assertContains('product_id', $fillable);
    }

    public function test_wishlist_belongs_to_user(): void
    {
        $wl = $this->makeWishlist();
        $this->assertInstanceOf(User::class, $wl->user);
    }

    public function test_wishlist_belongs_to_product(): void
    {
        $wl = $this->makeWishlist();
        $this->assertInstanceOf(Product::class, $wl->product);
    }

    public function test_wishlist_can_be_created_in_database(): void
    {
        $wl = $this->makeWishlist();
        $this->assertDatabaseHas('wishlists', [
            'user_id'    => $wl->user_id,
            'product_id' => $wl->product_id,
        ]);
    }


    // ===== UserAddress =====

    public function test_user_address_has_fillable_attributes(): void
    {
        $addr     = new UserAddress();
        $fillable = $addr->getFillable();

        foreach (['user_id', 'label', 'recipient_name', 'phone', 'alamat',
                  'province_code', 'regency_code', 'district_code', 'village_code',
                  'propinsi', 'kota', 'kecamatan', 'kelurahan', 'rt', 'rw', 'kodepos',
                  'is_primary'] as $field) {
            $this->assertContains($field, $fillable);
        }
    }

    public function test_user_address_is_primary_is_cast_to_boolean(): void
    {
        $user = User::factory()->create();
        $addr = UserAddress::create([
            'user_id'        => $user->id,
            'label'          => 'Rumah',
            'recipient_name' => 'Budi',
            'phone'          => '081234567890',
            'alamat'         => 'Jl. Merdeka No.1',
            'province_code'  => '32',
            'regency_code'   => '3273',
            'district_code'  => '327301',
            'village_code'   => '3273010001',
            'propinsi'       => 'Jawa Barat',
            'kota'           => 'Kota Bandung',
            'kecamatan'      => 'Kecamatan Test',
            'kelurahan'      => 'Kelurahan Test',
            'rt'             => '001',
            'rw'             => '002',
            'kodepos'        => '40111',
            'is_primary'     => true,
        ]);

        $this->assertTrue($addr->is_primary);
        $this->assertIsBool($addr->is_primary);
    }

    public function test_user_address_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $addr = UserAddress::create([
            'user_id'        => $user->id,
            'label'          => 'Kantor',
            'recipient_name' => 'Siti',
            'phone'          => '082345678901',
            'alamat'         => 'Jl. Sudirman No.5',
            'province_code'  => '31',
            'regency_code'   => '3174',
            'district_code'  => '317401',
            'village_code'   => '3174010001',
            'propinsi'       => 'DKI Jakarta',
            'kota'           => 'Jakarta Selatan',
            'kecamatan'      => 'Setiabudi',
            'kelurahan'      => 'Karet Semanggi',
            'rt'             => '003',
            'rw'             => '005',
            'kodepos'        => '12930',
            'is_primary'     => false,
        ]);

        $this->assertInstanceOf(User::class, $addr->user);
        $this->assertEquals($user->id, $addr->user->id);
    }

    // ===== Courier + CourierService =====

    public function test_courier_has_fillable_attributes(): void
    {
        $courier  = new Courier();
        $fillable = $courier->getFillable();

        foreach (['name', 'code', 'logo', 'description', 'is_active'] as $field) {
            $this->assertContains($field, $fillable);
        }
    }

    public function test_courier_is_active_is_cast_to_boolean(): void
    {
        $courier = Courier::create([
            'name'      => 'JNE',
            'code'      => 'jne',
            'is_active' => true,
        ]);

        $this->assertTrue($courier->is_active);
        $this->assertIsBool($courier->is_active);
    }

    public function test_courier_has_many_services(): void
    {
        $courier = Courier::create(['name' => 'JNE', 'code' => 'jne', 'is_active' => true]);
        CourierService::create([
            'courier_id'     => $courier->id,
            'name'           => 'REG',
            'code'           => 'reg',
            'estimated_days' => '3-4',
            'is_active'      => true,
        ]);

        $this->assertCount(1, $courier->services);
    }

    public function test_courier_active_services_filters_inactive(): void
    {
        $courier = Courier::create(['name' => 'SiCepat', 'code' => 'sicepat', 'is_active' => true]);
        CourierService::create([
            'courier_id'     => $courier->id,
            'name'           => 'REG',
            'code'           => 'reg',
            'estimated_days' => '2-3',
            'is_active'      => true,
        ]);
        CourierService::create([
            'courier_id'     => $courier->id,
            'name'           => 'CARGO',
            'code'           => 'cargo',
            'estimated_days' => '5-7',
            'is_active'      => false,
        ]);

        $this->assertCount(1, $courier->activeServices);
        $this->assertEquals('REG', $courier->activeServices->first()->name);
    }

    public function test_courier_service_has_fillable_attributes(): void
    {
        $service  = new CourierService();
        $fillable = $service->getFillable();

        foreach (['courier_id', 'name', 'code', 'estimated_days', 'is_active'] as $field) {
            $this->assertContains($field, $fillable);
        }
    }

    public function test_courier_service_belongs_to_courier(): void
    {
        $courier = Courier::create(['name' => 'J&T', 'code' => 'jnt', 'is_active' => true]);
        $service = CourierService::create([
            'courier_id'     => $courier->id,
            'name'           => 'EZ',
            'code'           => 'ez',
            'estimated_days' => '2-3',
            'is_active'      => true,
        ]);

        $this->assertInstanceOf(Courier::class, $service->courier);
        $this->assertEquals($courier->id, $service->courier->id);
    }
}
