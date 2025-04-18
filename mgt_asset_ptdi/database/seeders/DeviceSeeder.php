<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $listDevice = [];
        $noPmnOptions = ['PMN001', 'PMN002'];

        for ($i = 1; $i <= 10; $i++) {
            $idKategori = [1, 3, 4][array_rand([1, 3, 4])];

            $idTipeOptions = [];
            if ($idKategori === 1) {
                $idTipeOptions = [1, 2, 3]; 
            } elseif ($idKategori === 3) {
                $idTipeOptions = [6, 7, 8]; 
            } elseif ($idKategori === 4) {
                $idTipeOptions = [9]; 
            }

            $idTipe = $idTipeOptions[array_rand($idTipeOptions)];

            $processor = rand(4, 5);

            $listDevice[] = [
                'nomor_it' => 'IT' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'no_pmn' => $noPmnOptions[array_rand($noPmnOptions)],
                'id_kategori' => $idKategori,
                'id_tipe' => $idTipe,
                'processor' => $processor,
                'storage_type' => 10,
                'storage_capacity' => 512,
                'memory_type' => 11,
                'memory_capacity' => 16,
                'vga_type' => 12,
                'vga_capacity' => 8,
                'serial_number' => Str::random(10),
                'operation_system' => 13,
                'os_license' => 15,
                'office' => 14,
                'office_license' => 15,
                'umur' => Carbon::now()->subYears(rand(0, 10))->toDateString(),
                'aplikasi_lainnya' => '-',
                'keterangan_tambahan' => '-',
                'kondisi' => (string) rand(0, 1), 
                'foto_kondisi' => 'foto_kondisi_' . uniqid(), 
            ];
        }

        foreach ($listDevice as $device) {
            Device::create($device);
        }
    }
}