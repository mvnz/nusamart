<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Laravolt\Indonesia\Seeds\DatabaseSeeder::class);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'phone' => '081200000000',
            'alamat' => 'Kantor Pusat NusaMart',
            'province_code' => '31',
            'regency_code' => '3171',
            'district_code' => '317101',
            'village_code' => '3171010001',
            'propinsi' => 'DKI JAKARTA',
            'kota' => 'KOTA JAKARTA PUSAT',
            'kecamatan' => 'GAMBIR',
            'kelurahan' => 'GAMBIR',
            'rt' => '001',
            'rw' => '001',
            'kodepos' => '10110',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $this->call(CreateTestUsersSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(InaExportProductSeeder::class);
<<<<<<< HEAD
        $this->call(KulinerSeeder::class);
=======
>>>>>>> 719bb98 (feat: add product recommendation on product detail page)
    }
}
