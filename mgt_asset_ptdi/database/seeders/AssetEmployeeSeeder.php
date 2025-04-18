<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetEmployee;

class AssetEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetEmployee::insert([
            [
                'nomor_asset' => 'ASSET001',
                'nik' => '130013', 
                'lokasi' => 'Jakarta', 
                'nomor_it' => 'DEV001', 
                'status_pengalihan' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // [
            //     'nomor_asset' => 'ASSET002',
            //     'nik' => '130013', 
            //     'lokasi' => 'Jakarta', 
            //     'nomor_it' => 'DEV001', 
            //     'status_pengalihan' => 1, 
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);

        
    }
}
