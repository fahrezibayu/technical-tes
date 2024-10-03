<?php

namespace Database\Seeders;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    public function run()
    {
        Location::create([
            'latitude' => -6.9932,
            'longitude' => 110.4213,
            'no_lahan' => '001',
            'nama_petani' => 'Petani A',
            'polygon' => 'POLYGON((110.4200 -6.9940, 110.4220 -6.9940, 110.4220 -6.9920, 110.4200 -6.9920, 110.4200 -6.9940))',
        ]);

        Location::create([
            'latitude' => -6.9835,
            'longitude' => 110.4204,
            'no_lahan' => '002',
            'nama_petani' => 'Petani B',
            'polygon' => 'POLYGON((110.4190 -6.9845, 110.4210 -6.9845, 110.4210 -6.9825, 110.4190 -6.9825, 110.4190 -6.9845))',
        ]);

        Location::create([
            'latitude' => -6.9920,
            'longitude' => 110.4270,
            'no_lahan' => '003',
            'nama_petani' => 'Petani C',
            'polygon' => 'POLYGON((110.4260 -6.9930, 110.4280 -6.9930, 110.4280 -6.9910, 110.4260 -6.9910, 110.4260 -6.9930))',
        ]);

        Location::create([
            'latitude' => -6.9850,
            'longitude' => 110.4250,
            'no_lahan' => '004',
            'nama_petani' => 'Petani D',
            'polygon' => 'POLYGON((110.4240 -6.9860, 110.4260 -6.9860, 110.4260 -6.9840, 110.4240 -6.9840, 110.4240 -6.9860))',
        ]);

        Location::create([
            'latitude' => -6.9790,
            'longitude' => 110.4180,
            'no_lahan' => '005',
            'nama_petani' => 'Petani E',
            'polygon' => 'POLYGON((110.4170 -6.9800, 110.4190 -6.9800, 110.4190 -6.9780, 110.4170 -6.9780, 110.4170 -6.9800))',
        ]);
    }
}
