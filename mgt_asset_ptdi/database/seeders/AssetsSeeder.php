<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [
            [
                'nomor_it' => 'IT000001',
                'no_pmn' => 'PMN123',
                'id_kategori' => 1,
                'id_tipe' => 1,
                'processor' => 4,
                'storage_type' => 10,
                'storage_capacity' => 512,
                'memory_type' => 11,
                'memory_capacity' => 16,
                'vga_type' => 12,
                'vga_capacity' => 300,
                'serial_number' => '-',
                'operation_system' => 13,
                'os_license' => 15,
                'office' => 14,
                'office_license' => 15,
                'umur' => '2025-01-08',
                'aplikasi_lainnya' => '-',
                'keterangan_tambahan' => '-',
            ],
        ];

        foreach ($devices as $device) {
            Assets::create($device);
        }
    }
}