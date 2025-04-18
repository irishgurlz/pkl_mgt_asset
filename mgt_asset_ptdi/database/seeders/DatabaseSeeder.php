<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organisasi;
use App\Models\Jabatan;
use App\Models\Employee;
use App\Models\Pendanaan;
use App\Models\Asset;
use App\Models\Device;
use App\Models\Distribution;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            SubKategoriSeeder::class,
        ]);


        $nama_organisasi = [
            'Divisi Pengembangan Sumber Daya Manusia',
            'Bidang Manajemen Pengetahuan',
            'Manajemen Aset dan Tata Kelola'
        ];

        foreach ($nama_organisasi as $index => $nama) {
            $kode = 'HD' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            
            $organisasi = Organisasi::create([
                'kode_org' => $kode,
                'nama' => $nama,
            ]);
        }

        $nama_jabatan = [
            'ALL',
            'KDV',
            'KDP',
            'KBD',
            'STF'
        ];
        
        foreach ($nama_jabatan as $index => $nama) {
            $jabatan = Jabatan::create([
                'nama' => $nama,
            ]);
        }

        $pendanaan = Pendanaan::insert([
            ['no_pmn' => 'PMN001',
            'deskripsi' => null,
            'tanggal' => '2024-01-20',
            'file_attach' => hash('sha256', 'dokumen_pendanaan_awal.pdf'),
            ],
            ['no_pmn' => 'PMN002',
            'deskripsi' => null,
            'tanggal' => '2023-01-20',
            'file_attach' => hash('sha256', 'dokumen_pendanaan_laptop.pdf'),
            ],
        ]);

        $asset = Asset::create([
            'nomor_asset' => 'AS123',
            'no_pmn' => 'PMN002',
            'id_kategori' => 11,
            'id_tipe' => 17,
            'umur' => '2020-06-28',
            'foto' => 'public\dokumen\foto.jpg',
            'kondisi' => '0',
        ]);


        $asset = Asset::create([
            'nomor_asset' => 'AS124',
            'no_pmn' => 'PMN002',
            'id_kategori' => 11,
            'id_tipe' => 17,
            'umur' => '2020-06-28',
            'foto' => 'public\dokumen\foto.jpg',
            'kondisi' => '0',
        ]);


        $asset = Asset::create([
            'nomor_asset' => 'AS125',
            'no_pmn' => 'PMN002',
            'id_kategori' => 11,
            'id_tipe' => 18,
            'umur' => '2020-06-28',
            'foto' => 'public\dokumen\foto.jpg',
            'kondisi' => '1',
        ]);

        $this->call([
            DeviceSeeder::class,
            RoleSeeder::class,
        ]);
        DB::table('distribution')->insert([
            ['nomor_penyerahan' => 'PN123'],
        ]);
        
        $details = [
            ['nomor_penyerahan' => 'PN123', 'nomor_asset' => 'AS123', 'nomor_it' => null, 'tanggal' => '2025-02-08', 'deskripsi' => '-', 'file' => 'dokumen/1740112700_LEMBAR PENGESAHAN INDUSTRI_2501...', 'nik' => '098765', 'lokasi' => 'IT Lantai 1', 'status_pengalihan' => 0, 'status_pengajuan' => '0', 'deskripsi_pengajuan' => null],
            ['nomor_penyerahan' => 'PN123', 'nomor_asset' => 'AS124', 'nomor_it' => null, 'tanggal' => '2025-02-06', 'deskripsi' => '-', 'file' => 'dokumen/1740112700_LEMBAR PENGESAHAN INDUSTRI_2501...', 'nik' => '098765', 'lokasi' => 'IT Lantai 1', 'status_pengalihan' => 0, 'status_pengajuan' => '0', 'deskripsi_pengajuan' => null],
            ['nomor_penyerahan' => 'PN123', 'nomor_asset' => 'AS125', 'nomor_it' => null, 'tanggal' => '2025-02-07', 'deskripsi' => '-', 'file' => 'dokumen/1740112700_LEMBAR PENGESAHAN INDUSTRI_2501...', 'nik' => '123456', 'lokasi' => 'IT Lantai 2', 'status_pengalihan' => 0, 'status_pengajuan' => '0', 'deskripsi_pengajuan' => null],
        ];
        
        // Insert ke distribution_detail dan history
        foreach ($details as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        
            DB::table('distribution_detail')->insert($item);
        
            DB::table('history')->insert([
                'status_pengalihan'   => $item['status_pengalihan'],
                'nik'                 => $item['nik'],
                'nomor_penyerahan'    => $item['nomor_penyerahan'],
                'nomor_asset'         => $item['nomor_asset'],
                'nomor_it'            => $item['nomor_it'],
                'tanggal_pengalihan'  => $item['tanggal'],
                'dokumen_pengalihan'  => $item['file'],
                'created_at'          => $item['created_at'],
                'updated_at'          => $item['updated_at'],
            ]);
        }
        
        // Loop untuk data IT
        for ($i = 1; $i <= 10; $i++) {
            $data = [
                'nomor_penyerahan'   => 'PN123',
                'nomor_asset'        => null,
                'nomor_it'           => 'IT' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'tanggal'            => '2025-02-01',
                'deskripsi'          => '-',
                'file'               => 'dokumen/1740112792_LEMBAR PENGESAHAN INDUSTRI_2501...',
                'nik'                => $i % 2 == 0 ? '098765' : '123456',
                'lokasi'             => 'IT Lantai 1',
                'status_pengalihan'  => 0,
                'status_pengajuan'   => '0',
                'deskripsi_pengajuan'=> null,
                'created_at'         => now(),
                'updated_at'         => now()
            ];
        
            DB::table('distribution_detail')->insert($data);
        
            DB::table('history')->insert([
                'status_pengalihan'   => $data['status_pengalihan'],
                'nik'                 => $data['nik'],
                'nomor_penyerahan'    => $data['nomor_penyerahan'],
                'nomor_asset'         => $data['nomor_asset'],
                'nomor_it'            => $data['nomor_it'],
                'tanggal_pengalihan'  => $data['tanggal'],
                'dokumen_pengalihan'  => $data['file'],
                'created_at'          => $data['created_at'],
                'updated_at'          => $data['updated_at'],
            ]);
        }
        
        
        
    }
}
