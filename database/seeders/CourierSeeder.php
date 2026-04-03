<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\CourierService;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        $couriers = [
            ['name' => 'JNE',          'code' => 'jne',      'description' => 'Jalur Nugraha Ekakurir - pengiriman terpercaya sejak 1990'],
            ['name' => 'SiCepat',      'code' => 'sicepat',  'description' => 'Pengiriman cepat dan terjangkau ke seluruh Indonesia'],
            ['name' => 'JNT Express',  'code' => 'jnt',      'description' => 'J&T Express - solusi pengiriman modern'],
            ['name' => 'TIKI',         'code' => 'tiki',     'description' => 'Titipan Kilat - kurir ekspres nasional'],
            ['name' => 'Pos Indonesia','code' => 'pos',      'description' => 'Layanan pengiriman resmi milik negara'],
            ['name' => 'AnterAja',     'code' => 'anteraja', 'description' => 'Anter Aja - pengiriman lokal cepat'],
        ];

        $services = [
            'jne'      => [
                ['name' => 'Reguler',                   'code' => 'REG',   'estimated_days' => '2-4'],
                ['name' => 'YES (Yakin Esok Sampai)',    'code' => 'YES',   'estimated_days' => '1'],
                ['name' => 'OKE (Ongkos Kirim Ekonomis)','code' => 'OKE',  'estimated_days' => '4-7'],
                ['name' => 'Kargo',                     'code' => 'JTR',   'estimated_days' => '3-7'],
            ],
            'sicepat'  => [
                ['name' => 'BEST (Besok Sampai)',        'code' => 'BEST',  'estimated_days' => '1'],
                ['name' => 'Reguler',                   'code' => 'REG',   'estimated_days' => '2-3'],
                ['name' => 'Cargo',                     'code' => 'CARGO', 'estimated_days' => '3-5'],
                ['name' => 'Gokil',                     'code' => 'GOKIL', 'estimated_days' => '3-5'],
            ],
            'jnt'      => [
                ['name' => 'Express',                   'code' => 'EZ',    'estimated_days' => '1-3'],
                ['name' => 'Economy',                   'code' => 'ECO',   'estimated_days' => '3-5'],
            ],
            'tiki'     => [
                ['name' => 'Reguler',                   'code' => 'REG',   'estimated_days' => '3-5'],
                ['name' => 'Economy',                   'code' => 'ECO',   'estimated_days' => '5-8'],
                ['name' => 'ONS (Over Night Service)',  'code' => 'ONS',   'estimated_days' => '1'],
            ],
            'pos'      => [
                ['name' => 'Kilat Khusus',              'code' => 'KKB',   'estimated_days' => '2-3'],
                ['name' => 'Biasa',                     'code' => 'BAS',   'estimated_days' => '7-10'],
            ],
            'anteraja' => [
                ['name' => 'Same Day',                  'code' => 'SD',    'estimated_days' => '0-1'],
                ['name' => 'Next Day',                  'code' => 'ND',    'estimated_days' => '1'],
                ['name' => 'Reguler',                   'code' => 'REG',   'estimated_days' => '2-3'],
            ],
        ];

        foreach ($couriers as $courierData) {
            $courier = Courier::firstOrCreate(
                ['code' => $courierData['code']],
                $courierData
            );

            if (isset($services[$courierData['code']])) {
                foreach ($services[$courierData['code']] as $svc) {
                    $courier->services()->firstOrCreate(
                        ['code' => $svc['code']],
                        $svc
                    );
                }
            }
        }
    }
}
